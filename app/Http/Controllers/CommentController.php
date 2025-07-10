<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Service, Produit, Comment};

class CommentController extends Controller
{
        /**
         * Enregistre un commentaire pour un service ou un produit.
         * Renvie du JSON si la requête est AJAX (wantsJson), sinon fait un redirect classique.
         */
        public function storeComment(Request $request, $type, $id)
        {
            // 1️⃣ On détermine le modèle cible selon le type (service ou product)
            $model = $type === 'service'
                ? Service::findOrFail($id)
                : Produit::findOrFail($id);

            // 2️⃣ On construit les règles de validation
            //    - body : toujours obligatoire
            //    - si invité (guest), guest_name et guest_email sont requis
            $rules = [
                'body' => 'required|string',
            ];
            if (auth()->guest()) {
                $rules['guest_name']  = 'required|string|max:100';
                $rules['guest_email'] = 'required|email|max:150';
            }

            // 3️⃣ Validation des données
            $data = $request->validate($rules);

            // 4️⃣ Préparation des données à insérer
            $commentData = [
                'body'         => $data['body'],
                'user_id'      => auth()->id(),                     // null pour les invités
                'guest_name'   => $data['guest_name']   ?? null,    // nom de l’invité
                'guest_email'  => $data['guest_email']  ?? null,    // e-mail de l’invité
            ];

            // 5️⃣ Création du commentaire lié à l’entité (service ou produit)
            $comment = $model->comments()->create($commentData);

            // 6️⃣ Si c’est une requête AJAX (fetch, axios, etc.), on renvoie du JSON
            if ($request->wantsJson()) {
    // ici on renvoie la date en “diffForHumans” en français
            $dateHuman = $comment->created_at
                            ->locale('fr')           // français
                            ->diffForHumans();       // “il y a 5 minutes”, etc.

                // on "hydrate" la relation user pour récupérer son nom et son avatar
                $comment->load('user');

                return response()->json([
                    'success'        => true,
                    // contenu du commentaire
                    'body'        => $comment->body,
                    // nom de l’auteur : user connecté ou guest_name
                    'author_name' => $comment->user
                                    ? $comment->user->name
                                    : $comment->guest_name,
                    // date formatée (ex. "June 24, 2025")
                    'date'        =>$dateHuman,
                    // URL de l’avatar : user avatar_url ou image par défaut
                    'avatar_url'  => $comment->user
                                    ? $comment->user->avatar_url
                                    : asset('assets/img/default.jpg'),
                ], 200);
            }

            // 7️⃣ Sinon, on redirige normalement avec un message de session
            return back()->with('success', 'Commentaire publié avec succès !');
        }
        public function latestComments(Request $request, $type, $id)
        {
            // 1️⃣ On identifie le modèle (Service ou Product)
            $model = $type === 'service'
                ? Service::findOrFail($id)
                : Produit::findOrFail($id);

            // 2️⃣ On récupère les 5 derniers commentaires, avec l’utilisateur pour le nom/avatar
            $comments = $model
                ->comments()
                ->with('user')
                ->latest()     // tri par created_at DESC
                ->take(5)
                ->get();

            // 3️⃣ On transforme la collection en tableau de données simples
            $data = $comments->map(function($c) {
                return [
                    'body'        => $c->body,
                    'author_name' => $c->user ? $c->user->name : $c->guest_name,
                    'date'        => $c->created_at->locale('fr')->diffForHumans(),
                    'avatar_url'  => $c->user
                        ? $c->user->avatar_url
                        : asset('assets/img/default.jpg'),
                ];
            });

            // 4️⃣ On renvoie le JSON
            return response()->json($data);
        }
        // Et ajoutez aussi, pour le modal, une route ALL Comments :
        // Route::get('{type}/{id}/comments/all', [CommentController::class,'allComments']);
        public function allComments(Request $request, $type, $id)
        {
            $model = $type==='service'
                ? Service::findOrFail($id)
                : Produit::findOrFail($id);

            $comments = $model->comments()
                            ->with('user')
                            ->oldest()  // du plus ancien au plus récent
                            ->get();

            $data = $comments->map(function($c){
                return [
                    'body'        => $c->body,
                    'author_name' => $c->user ? $c->user->name : $c->guest_name,
                    'date'        => $c->created_at->locale('fr')->diffForHumans(),
                    'avatar_url'  => $c->user
                                    ? $c->user->avatar_url
                                    : asset('assets/img/default.jpg'),
                ];
            });

            return response()->json($data);
        }
}
