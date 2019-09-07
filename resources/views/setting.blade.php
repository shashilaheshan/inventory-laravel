@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Settings</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ url('editCompanyInformation') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="companyName" class="col-md-4 control-label">Company Name</label>
                            <div class="col-md-6">
                                <input id="companyName" type="text" class="form-control" name="companyName" value="{{$companyInformations->company_name}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="companyPhoneNumber" class="col-md-4 control-label">Phone Number</label>
                            <div class="col-md-6">
                                <input id="companyPhoneNumber" type="text" class="form-control" name="companyPhoneNumber" value="{{$companyInformations->phone_number}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="companyAddress" class="col-md-4 control-label">Company Address</label>
                            <div class="col-md-6">
                                <input id="companyAddress" type="text" class="form-control" name="companyAddress" value="{{$companyInformations->address}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="companyLogo" class="col-md-4 control-label">Company Logo</label>
                            <div class="col-md-6">
                                 <input type="file" name="logo" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="currentLogo" class="col-md-4 control-label">Current Logo</label>
                            <div class="col-md-6">
                                <img class="currentLogo" src="/resources/assets/uploads/logo/{{getTheCompanyFavicon()}}" width="100" height="100" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="currencies" class="col-md-4 control-label">Currency</label>
                            <div class="col-md-6">
                                <select name="currencies" id="currencies" class="form-control" required="">
                                    <option value="{{$companyInformations->currency}}">{{$companyInformations->currency}}</option>
                                    <option value="USD">America (United States) Dollars – USD</option>
                                    <option value="AFN">Afghanistan Afghanis – AFN</option>
                                    <option value="ALL">Albania Leke – ALL</option>
                                    <option value="DZD">Algeria Dinars – DZD</option>
                                    <option value="ARS">Argentina Pesos – ARS</option>
                                    <option value="AUD">Australia Dollars – AUD</option>
                                    <option value="ATS">Austria Schillings – ATS</OPTION>

                                    <option value="BSD">Bahamas Dollars – BSD</option>
                                    <option value="BHD">Bahrain Dinars – BHD</option>
                                    <option value="BDT">Bangladesh Taka – BDT</option>
                                    <option value="BBD">Barbados Dollars – BBD</option>
                                    <option value="BEF">Belgium Francs – BEF</OPTION>
                                    <option value="BMD">Bermuda Dollars – BMD</option>

                                    <option value="BRL">Brazil Reais – BRL</option>
                                    <option value="BGN">Bulgaria Leva – BGN</option>
                                    <option value="CAD">Canada Dollars – CAD</option>
                                    <option value="XOF">CFA BCEAO Francs – XOF</option>
                                    <option value="XAF">CFA BEAC Francs – XAF</option>
                                    <option value="CLP">Chile Pesos – CLP</option>

                                    <option value="CNY">China Yuan Renminbi – CNY</option>
                                    <option value="COP">Colombia Pesos – COP</option>
                                    <option value="XPF">CFP Francs – XPF</option>
                                    <option value="CRC">Costa Rica Colones – CRC</option>
                                    <option value="HRK">Croatia Kuna – HRK</option>

                                    <option value="CYP">Cyprus Pounds – CYP</option>
                                    <option value="CZK">Czech Republic Koruny – CZK</option>
                                    <option value="DKK">Denmark Kroner – DKK</option>
                                    <option value="DEM">Deutsche (Germany) Marks – DEM</OPTION>
                                    <option value="DOP">Dominican Republic Pesos – DOP</option>
                                    <option value="NLG">Dutch (Netherlands) Guilders – NLG</OPTION>

                                    <option value="XCD">Eastern Caribbean Dollars – XCD</option>
                                    <option value="EGP">Egypt Pounds – EGP</option>
                                    <option value="EEK">Estonia Krooni – EEK</option>
                                    <option value="EUR">Euro – EUR</option>
                                    <option value="FJD">Fiji Dollars – FJD</option>
                                    <option value="FIM">Finland Markkaa – FIM</OPTION>

                                    <option value="FRF*">France Francs – FRF*</OPTION>
                                    <option value="DEM">Germany Deutsche Marks – DEM</OPTION>
                                    <option value="XAU">Gold Ounces – XAU</option>
                                    <option value="GRD">Greece Drachmae – GRD</OPTION>
                                    <option value="GTQ">Guatemalan Quetzal – GTQ</OPTION>
                                    <option value="NLG">Holland (Netherlands) Guilders – NLG</OPTION>
                                    <option value="HKD">Hong Kong Dollars – HKD</option>

                                    <option value="HUF">Hungary Forint – HUF</option>
                                    <option value="ISK">Iceland Kronur – ISK</option>
                                    <option value="XDR">IMF Special Drawing Right – XDR</option>
                                    <option value="INR">India Rupees – INR</option>
                                    <option value="IDR">Indonesia Rupiahs – IDR</option>
                                    <option value="IRR">Iran Rials – IRR</option>

                                    <option value="IQD">Iraq Dinars – IQD</option>
                                    <option value="IEP*">Ireland Pounds – IEP*</OPTION>
                                    <option value="ILS">Israel New Shekels – ILS</option>
                                    <option value="ITL*">Italy Lire – ITL*</OPTION>
                                    <option value="JMD">Jamaica Dollars – JMD</option>
                                    <option value="JPY">Japan Yen – JPY</option>

                                    <option value="JOD">Jordan Dinars – JOD</option>
                                    <option value="KES">Kenya Shillings – KES</option>
                                    <option value="KRW">Korea (South) Won – KRW</option>
                                    <option value="KWD">Kuwait Dinars – KWD</option>
                                    <option value="LBP">Lebanon Pounds – LBP</option>
                                    <option value="LUF">Luxembourg Francs – LUF</OPTION>

                                    <option value="MYR">Malaysia Ringgits – MYR</option>
                                    <option value="MTL">Malta Liri – MTL</option>
                                    <option value="MUR">Mauritius Rupees – MUR</option>
                                    <option value="MXN">Mexico Pesos – MXN</option>
                                    <option value="MAD">Morocco Dirhams – MAD</option>
                                    <option value="NLG">Netherlands Guilders – NLG</OPTION>

                                    <option value="NZD">New Zealand Dollars – NZD</option>
                                    <option value="NOK">Norway Kroner – NOK</option>
                                    <option value="OMR">Oman Rials – OMR</option>
                                    <option value="PKR">Pakistan Rupees – PKR</option>
                                    <option value="XPD">Palladium Ounces – XPD</option>
                                    <option value="PEN">Peru Nuevos Soles – PEN</option>

                                    <option value="PHP">Philippines Pesos – PHP</option>
                                    <option value="XPT">Platinum Ounces – XPT</option>
                                    <option value="PLN">Poland Zlotych – PLN</option>
                                    <option value="PTE">Portugal Escudos – PTE</OPTION>
                                    <option value="QAR">Qatar Riyals – QAR</option>
                                    <option value="RON">Romania New Lei – RON</option>

                                    <option value="ROL">Romania Lei – ROL</option>
                                    <option value="RUB">Russia Rubles – RUB</option>
                                    <option value="SAR">Saudi Arabia Riyals – SAR</option>
                                    <option value="XAG">Silver Ounces – XAG</option>
                                    <option value="SGD">Singapore Dollars – SGD</option>
                                    <option value="SKK">Slovakia Koruny – SKK</option>

                                    <option value="SIT">Slovenia Tolars – SIT</option>
                                    <option value="ZAR">South Africa Rand – ZAR</option>
                                    <option value="KRW">South Korea Won – KRW</option>
                                    <option value="ESP">Spain Pesetas – ESP</OPTION>
                                    <option value="XDR">Special Drawing Rights (IMF) – XDR</option>
                                    <option value="LKR">Sri Lanka Rupees – LKR</option>

                                    <option value="SDD">Sudan Dinars – SDD</option>
                                    <option value="SEK">Sweden Kronor – SEK</option>
                                    <option value="CHF">Switzerland Francs – CHF</option>
                                    <option value="TWD">Taiwan New Dollars – TWD</option>
                                    <option value="THB">Thailand Baht – THB</option>
                                    <option value="TTD">Trinidad and Tobago Dollars – TTD</option>

                                    <option value="TND">Tunisia Dinars – TND</option>
                                    <option value="TRY">Turkey New Lira – TRY</option>
                                    <option value="AED">United Arab Emirates Dirhams – AED</option>
                                    <option value="GBP">United Kingdom Pounds – GBP</option>
                                    <option value="VEB">Venezuela Bolivares – VEB</option>

                                    <option value="VND">Vietnam Dong – VND</option>
                                    <option value="ZMK">Zambia Kwacha – ZMK</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timezone" class="col-md-4 control-label">Time Zone</label>
                            <div class="col-md-6">
                                <select name="timezone" id="timezone" class="form-control" required="">
                                    <option value="{{$companyInformations->time_zone}}">{{$companyInformations->time_zone}}</option>
                                      <option value="US/Samoa">(GMT -11:00) Midway Island, Samoa</option>
                                      <option value="US/Hawaii">(GMT -10:00) Hawaii</option>
                                      <option value="US/Alaska">(GMT -9:00) Alaska</option>
                                      <option value="US/Pacific">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                                      <option value="US/Mountain">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                                      <option value="US/Central">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
                                      <option value="US/Eastern">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                                      <option value="Canada/Atlantic">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                                      <option value="America/Buenos_Aires">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                                      <option value="Atlantic/Stanley">(GMT -2:00) Mid-Atlantic</option>
                                      <option value="Atlantic/Azores">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                                      <option value="Europe/London">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
                                      <option value="Europe/Paris">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                                      <option value="Europe/Istanbul">(GMT +2:00) Kaliningrad, South Africa</option>
                                      <option value="Asia/Baghdad">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                                      <option value="Asia/Tbilisi">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                                      <option value="Asia/Karachi">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                                      <option value="Asia/Dhaka">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                                      <option value="Asia/Jakarta">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                                      <option value="Australia/Perth">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                                      <option value="Asia/Tokyo">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                                      <option value="Pacific/Guam">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                                      <option value="Asia/Vladivostok">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                                      <option value="Pacific/Fiji">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="defaultVat" class="col-md-4 control-label">Default Vat (%)</label>
                            <div class="col-md-6">
                                <input id="defaultVat" type="text" class="form-control" name="defaultVat" value="{{$companyInformations->default_vat}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="delivery_charge" class="col-md-4 control-label">Delivery Charge</label>
                            <div class="col-md-6">
                                <input id="delivery_charge" type="text" class="form-control" name="delivery_charge" value="{{$companyInformations->delivery_charge}}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
