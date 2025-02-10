@include("parties.entete")
@include("parties.menu")
<main>
    @if (session()->has('retour'))
    <div class="alert {{session()->get('retour')["reponse"]==true?"alert-success":"alert-danger"}}">
        {{ session()->get('retour')["message"] }}
    </div>
@endif
@yield("content")
</main>
@include("parties.footer")
@include("parties.pied")
