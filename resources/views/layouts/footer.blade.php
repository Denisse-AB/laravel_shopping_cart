@section('footer')
    <div id="footer" style="background-color: #4dc0b5;">
        <div class="container-fluid padding">
            <div class="row text-center padding">
                <div class="col-12">
                    <h5 class="display-4 pt-3" id="font">E-Shop</h5>
                    <hr>
                </div>

                <div class="col-12 social p-3">
                    <a href="#"><i class="fab fa-facebook-square"></i></a>
                    <a href="#"><i class="fab fa-twitter-square"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                </div>
            </div>
        </div>
        <div class="container-fluid text-center">
            <div class="row padding">
                <div class="col-md-4">
                    <h4>@lang('You will find Us')</h4>
                    <hr class="light">
                    <p>787-000-0000</p>
                    <p>Email: example@yahoo.com</p>
                    <p>@lang('Phisical adress')</p>
                    <p>#00 str. name</p>
                    <p>city, country 0000</p>
                </div>

                <div class="col-md-4">
                    <h4>@lang('Hours of services')</h4>
                    <hr class="light">
                    <p>@lang('Mon-Fri'): 8-5</p>
                    <p>@lang('Sat'): 9-1</p>
                    <p>@lang('Sun: closed')</p>
                </div>

                <div class="col-md-4">
                    <h4>@lang('Service Areas')</h4>
                    <hr class="light">
                    <p>@lang('City State'), 0000</p>
                    <p>@lang('City State'), 0000</p>
                    <p>@lang('City State'), 0000</p>
                    <p>@lang('City State'), 0000</p>
                </div>
            </div>
        </div>
    </div>
    <!--copyrights-->
    <div class="col-12 text-center">
        <hr>
        <h5>& Copy; 2019 Company Name. All Rights Reserve</h5>
        <p>Font Awesome licensed under SIL OFL 1.1 · Code licensed under MIT License
            · Documentation licensed under CC BY 3.0 </p>
@endsection