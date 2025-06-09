<div class="col-lg-4 col-md-8">

    <aside class="shop-cart-sidebar checkout-sidebar" id="paiement-section" style="opacity: 0.5; pointer-events: none;">
        <div class="shop-cart-widget">
            <h6 class="title">Total à payé</h6>
            <form id="formpaie" action="{{ route('caisseService') }}" method="POST" onsubmit="submitForm(event)">
                @csrf
                @switch ($page)
                    @case('nouvelle-carte')
                        <ul>
                            <li><span>Livraison : </span><span id="afficheLivraison">0</span></li>
                            <li><span>1ier Depos : </span><span id="afficheDepos">0</span></li>
                            <li><span>Prix de la carte :</span><span
                                    id="cartePrice">{{ $serv->prix . '' . $serv->currency }}</span></li>
                            <li><span>Sous total :</span><span id="sousTotal">{{ $serv->prix . '' . $serv->currency }}</span>
                            </li>

                            <li class="cart-total-amount"><span>TOTAL</span>
                                <span class="amount" id="totalAff"> {{ $serv->prix . '' . $serv->currency }}</span>
                            </li>
                        </ul>
                    @break

                    @case('renouveler-carte')
                        <ul>
                            <li><span>Livraison : </span><span id="afficheLivraison">0</span></li>
                            <li><span>1ier Depos : </span><span id="afficheDepos">0</span></li>
                            <li><span>Prix de la carte :</span><span
                                    id="cartePrice">{{ $serv->prix . '' . $serv->currency }}</span></li>
                            <li><span>Sous total :</span><span id="sousTotal">{{ $serv->prix . '' . $serv->currency }}</span>
                            </li>

                            <li class="cart-total-amount"><span>TOTAL</span>
                                <span class="amount" id="totalAff"> {{ $serv->prix . '' . $serv->currency }}</span>
                            </li>
                        </ul>
                    @break

                    @case('recharge-carte')
                        <ul>
                            <li><span id="affId"></span></li>
                            <li><span id="affNumCarte"></span></li>
                            <li><span id="affMontant"></span></li>
                        </ul>
                    @break

                    @default
                        <p>Pas d'informations</p>
                @endswitch
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 mb-10">
                            <div class="form-grp">
                                <label>Moyen de paiement*</label>
                                <select required class="custom-select" name="channel" id="channel">
                                    <option value="" selected>Selectionnez un moyen de paiement
                                    </option>
                                    <option value="mobile_money">Mobile money</option>
                                    <option value="card">Carte bancaire</option>
                                    {{-- <option value="California">Cash</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12" id="Contenairephone">

                            <div class="form-grp">
                                <label>Numéro de téléphone :</label>
                                <input class="custom-select" name="phone" type="text" id="phone"
                                    placeholder="24382XXXXX">
                                <input class="custom-select d-none" value="" name="total" type="text"
                                    id="total">
                                <input class="custom-select d-none" value="" name="currency" type="text"
                                    id="currency">
                                <input class="custom-select d-none" value="" name="slug" type="text"
                                    id="slug">
                                <input class="custom-select d-none" value="" name="referenceCreate" type="text"
                                    id="referenceCreate">
                            </div>
                        </div>
                    </div>
                    <div class="payment-terms">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" required class="custom-control-input" id="customCheck7">
                            <label class="custom-control-label" for="customCheck7">J'ai lu et j'accepte
                                les
                                conditions générales
                                du site Web*</label>
                        </div>
                    </div>
                    <button type="submit" class="btn" disabled id="btn-paiement">PASSER À LA CAISSE</button>
            </form>
        </div>
    </aside>

</div>
