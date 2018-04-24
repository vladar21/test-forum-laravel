{{-- Social buttons--}}

<div class="text-left margin-bottom-10" id="uLogin"
     data-ulogin="display=panel;theme=flat;fields=first_name,last_name,email;
                             providers=facebook,linkedin,google;
                             redirect_uri={{ urlencode('http://' . $_SERVER['HTTP_HOST']) }}/ulogin;mobilebuttons=0;">
</div>

@section('js1')
    <script src="//ulogin.ru/js/ulogin.js"></script>
@endsection