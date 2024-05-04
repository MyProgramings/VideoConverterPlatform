<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فيديو حسوب</title>

    <!-- bootstarp -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/597cb1f685.js" crossorigin="anonymous"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{!! asset('theme/css/sb-admin-2.css') !!}" rel="stylesheet">

</head>
<body dir="rtl" style="text-align: right">
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light bg-white">
            <a class="navbar-brand" href="#">فيديو حسوب</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item  {{ request()->is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('main') }}">                           
                            <i class="fas fa-home"></i>
                                الصفحة الرئيسية  
                        </a>
                    </li>

                    <li class="nav-item {{ request()->is('videos/create*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('videos.create') }}">                                
                            <i class="fas fa-upload"></i>
                                رفع فيديو     
                        </a>
                    </li>


                    {{-- <li class="nav-item {{ request()->is('channel*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('channel.index') }}">                                
                            <i class="fas fa-film"></i>
                                 القنوات  
                        </a>
                    </li> --}}
                </ul>

            </div>
        </nav>

        <main class="py-4">
            
            @yield('content')
        </main>
    </div>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('0d7c055c9f991cc11d83', {
            cluster: 'mt1'
        });
    </script>
    <script src="{{asset('js/pushNotifications.js')}}"></script>
    <script src="{{asset('js/failedNotifications.js')}}"></script>

    <script>
        var token = '{{ Session::token() }}';
        var urlNotify = '#';

        $('#alertsDropdown').on('click', function(event) {
            event.preventDefault();
            var notificationsWrapper = $('.alert-dropdown');
            var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
            var notificationsCountElem = notificationsToggle.find('span[data-count]');
            
            notificationsCount = 0;
            notificationsCountElem.attr('data-count', notificationsCount);
            notificationsWrapper.find('.notif-count').text(notificationsCount);
            notificationsWrapper.show();

            $.ajax({
                method: 'POST',
                url: urlNotify,
                data: {
                    _token: token
                },
                success : function(data) {
                    var resposeNotifications = "";
                    $.each(data.someNotifications , function(i, item) {
                        var responseDate = new Date(item.created_at);
                        var date = responseDate.getFullYear()+'-'+(responseDate.getMonth()+1)+'-'+responseDate.getDate();
                        var time = responseDate.getHours() + ":" + responseDate.getMinutes() + ":" + responseDate.getSeconds();
                        
                        if (item.success) {
                            resposeNotifications += '<a class="dropdown-item d-flex align-items-center" href="#">\
                                                        <div class="ml-3">\
                                                            <div class="icon-circle bg-secondary">\
                                                                <i class="far fa-bell text-white"></i>\
                                                            </div>\
                                                        </div>\
                                                        <div>\
                                                            <div class="small text-gray-500">'+date+' الساعة '+time+'</div>\
                                                            <span>تهانينا لقد تم معالجة مقطع الفيديو <b>'+item.notification+'</b> بنجاح</span>\
                                                        </div>\
                                                    </a>';
                        } else {
                            resposeNotifications += '<a class="dropdown-item d-flex align-items-center" href="#">\
                                                        <div class="ml-3">\
                                                            <div class="icon-circle bg-secondary">\
                                                                <i class="far fa-bell text-white"></i>\
                                                            </div>\
                                                        </div>\
                                                        <div>\
                                                            <div class="small text-gray-500">'+date+' الساعة '+time+'</div>\
                                                            <span>للأسف حدث خطأ غير متوقع أثناء معالجة مقطع الفيديو <b>'+item.notification+'</b> يرجى رفعه مرة أخرى</span>\
                                                        </div>\
                                                    </a>';
                        }

                        $('.alert-body').html(resposeNotifications);
                   });
                }
            });
        });
    </script>
    @yield('script')
</body>
</html>