<?php
/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Notifications Language Lines
    |--------------------------------------------------------------------------
    |
    */

    // ===== ERROR PAGES
    // 400
    '400_title' => 'Mauvaise requête',
    '400_description' => 'Vérifiez votre requête s\'il vous plait !',
    // 401
    '401_title' => 'Non autorisé',
    '401_description' => 'Vous n\'avez pas d\'autorisation pour cette requête.',
    // 403
    '403_title' => 'Espace interdit',
    '403_description' => 'Cet espace n\'est pas permis.',
    // 404
    '404_title' => 'Page non trouvée',
    '404_description' => 'La page que vous cherchez n\'existe pas',
    // 405
    '405_title' => 'Méthode non permise',
    '405_description' => 'Votre requête est envoyée avec une mauvaise méthode.',
    // 419
    '419_title' => 'Page expirée',
    '419_description' => 'La page a mis longtemps sans activité.',
    // 500
    '500_title' => 'Erreur interne',
    '500_description' => 'Notre serveur rencontre un problème. Veuillez réessayez après quelques minutes s\'il vous plait !',
    // Others
    'expects_json' => 'La requête actuelle attend probablement une réponse JSON.',

    // ===== ALERTS
    'no_record' => 'Il n\'y a aucun enregistrement !',
    'create_error' => 'La création a échoué !',
    'update_error' => 'La modification a échoué !',
    'registered_data' => 'Données enregistrées',
    'required_fields' => 'Veuillez vérifier les champs obligatoires',
    'transaction_waiting' => 'Veuillez valider le message de votre opérateur sur votre téléphone. Ensuite appuyez sur le bouton ci-dessous.',
    'transaction_done' => 'Votre opération est terminée !',
    'transaction_failed' => 'L\'envoi de votre paiement a échoué',
    'transaction_type_error' => 'Veuillez choisir le type de transaction',
    'new_partner_message' => 'Vous pouvez maintenant vous connecter en tant que partenaire avec votre n° de téléphone. Mot de passe temportaire :',
    // Entity
    'find_all_entities_success' => 'Entités trouvées',
    'find_entity_success' => 'Entité trouvée',
    'find_entity_404' => 'Entité non trouvée',
    'create_entity_success' => 'Entité créée',
    'update_entity_success' => 'Entité modifiée',
    'delete_entity_success' => 'Entité supprimée',
    // Event
    'find_all_events_success' => 'Evénéments trouvés',
    'find_event_success' => 'Evénément trouvé',
    'find_event_404' => 'Evénément non trouvé',
    'create_event_success' => 'Evénément créé',
    'update_event_success' => 'Evénément modifié',
    'delete_event_success' => 'Evénément supprimé',
    // Faithful
    'find_all_faithfuls_success' => 'Fidèles trouvés',
    'find_faithful_success' => 'Fidèle trouvé',
    'find_faithful_404' => 'Fidèle non trouvé',
    'create_faithful_success' => 'Fidèle créé',
    'update_faithful_success' => 'Fidèle modifié',
    'delete_faithful_success' => 'Fidèle supprimé',
    // Gallery
    'find_all_galleries_success' => 'Galeries trouvées',
    'find_gallery_success' => 'Galerie trouvée',
    'find_gallery_404' => 'Galerie non trouvée',
    'create_gallery_success' => 'Galerie créée',
    'update_gallery_success' => 'Galerie modifiée',
    'delete_gallery_success' => 'Galerie supprimée',
    // Good
    'find_all_goods_success' => 'Biens trouvés',
    'find_good_success' => 'Bien trouvé',
    'find_good_404' => 'Bien non trouvé',
    'create_good_success' => 'Bien créé',
    'update_good_success' => 'Bien modifié',
    'delete_good_success' => 'Bien supprimé',
    // Minister
    'find_all_ministers_success' => 'Ministères trouvés',
    'find_minister_success' => 'Ministère trouvé',
    'find_minister_404' => 'Ministère non trouvé',
    'create_minister_success' => 'Ministère créé',
    'update_minister_success' => 'Ministère modifié',
    'delete_minister_success' => 'Ministère supprimé',
    // Post
    'find_all_posts_success' => 'Posts trouvés',
    'find_post_success' => 'Post trouvé',
    'find_post_404' => 'Post non trouvé',
    'create_post_success' => 'Post créé',
    'update_post_success' => 'Post modifié',
    'delete_post_success' => 'Post supprimé',
    // Program
    'find_all_programs_success' => 'Programmes trouvés',
    'find_program_success' => 'Programme trouvé',
    'find_program_404' => 'Programme non trouvé',
    'create_program_success' => 'Programme créé',
    'update_program_success' => 'Programme modifié',
    'delete_program_success' => 'Programme supprimé',
    // Projet
    'find_all_projets_success' => 'Projets trouvés',
    'find_projet_success' => 'Projet trouvé',
    'find_projet_404' => 'Projet non trouvé',
    'create_projet_success' => 'Projet créé',
    'update_projet_success' => 'Projet modifié',
    'delete_projet_success' => 'Projet supprimé',
    // Role
    'find_all_roles_success' => 'Rôles trouvés',
    'find_role_success' => 'Rôle trouvé',
    'find_role_404' => 'Rôle non trouvé',
    'create_role_success' => 'Rôle créé',
    'update_role_success' => 'Rôle modifié',
    'delete_role_success' => 'Rôle supprimé',
    // User
    'find_all_users_success' => 'Utilisateurs trouvés',
    'find_user_success' => 'Utilisateur trouvé',
    'find_api_token_success' => 'Jeton d\'API trouvé',
    'find_user_404' => 'Utilisateur non trouvé',
    'create_user_success' => 'Utilisateur créé',
    'create_user_SMS_failed' => 'Il y a un problème avec le service des SMS',
    'update_user_success' => 'Utilisateur modifié',
    'update_password_success' => 'Mot de passe modifié',
    'confirm_password_error' => 'Veuillez confirmer votre mot de passe',
    'confirm_new_password' => 'Veuillez confirmer le nouveau mot de passe',
    'delete_user_success' => 'Utilisateur supprimé',
    // Testimonial
    'find_all_testimonials_success' => 'Témoignages trouvés',
    'find_testimonial_success' => 'Témoignage trouvé',
    'find_testimonial_404' => 'Témoignage non trouvé',
    'create_testimonial_success' => 'Témoignage créé',
    'update_testimonial_success' => 'Témoignage modifié',
    'delete_testimonial_success' => 'Témoignage supprimé',
    // Payment
    'find_all_payments_success' => 'Paiements trouvés',
    'find_payment_success' => 'Paiement trouvé',
    'find_payment_404' => 'Paiement non trouvé',
    'processing_succeed' => 'Votre transaction a réussie. Vous pouvez la voir à la liste de vos paiements.',
    'error_while_processing' => 'Une erreur lors du traitement de votre requête',
    'process_failed' => 'Impossible de traiter la demande, veuillez réessayer',
    'process_canceled' => 'Vous avez annulé votre transaction',
    'create_payment_success' => 'Paiement créé',
    'update_payment_success' => 'Paiement modifié',
    'delete_payment_success' => 'Paiement supprimé',
];
