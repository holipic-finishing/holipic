<?php
    $SOCKET_IO_PORT = env('SOCKET_IO_PORT', 6001);

    $polyfills = [
        'Promise',
        'Object.assign',
        'Object.values',
        'Array.prototype.find',
        'Array.prototype.findIndex',
        'Array.prototype.includes',
        'String.prototype.includes',
        'String.prototype.startsWith',
        'String.prototype.endsWith',
    ];
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="{{asset('')}}">
    <!-- <link rel="shortcut icon" type="image/png" href="{{secure_asset('favicon.png')}}" />
    <link rel="stylesheet" type="text/css" href="{{secure_asset('css/app.css')}}"> -->
    <!-- <link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}" /> -->
    <link rel="shortcut icon" type="image/x-icon" href="images/HOLIPIC-FAVICON.png" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">

    <title>Holipic</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js"></script>
    <script src="https://kit.fontawesome.com/db37308111.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="app"></div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>

    <script>
        const SOCKET_IO_PORT = '{!! $SOCKET_IO_PORT !!}';
        console.log(SOCKET_IO_PORT);

        var socket = io(':' + SOCKET_IO_PORT, {
            secure: true
        });

        var global_notification = [];

    </script>

    <script>
        var OneSignal = window.OneSignal || [];

        OneSignal.push(["init", {
            appId: "{{ env("ONESIGNAL_APP_ID") }}",
            subdomainName: 'wbtotalter',
            autoRegister: false,
            safari_web_id: 'web.onesignal.auto.50d89199-747f-4818-96ca-50d4208129fc',
            // httpPermissionRequest: {
            //  enable: true
            // },
            notifyButton: {
                enable: true
            },
            welcomeNotification: {
                disable: true
            },
            promptOptions: {
                siteName: "Laravel Webpush Notification",
                actionMessage: "Can you use it when you can believe it or not?",
                acceptButtonText: "YES",
                cancelButtonText: "NO, THANK",
            }
        }]);

        OneSignal.push(function () {
            OneSignal.showHttpPrompt();
            // OneSignal.registerForPushNotifications();
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                console.log("The user's subscription state is now:", isSubscribed);
                OneSignal.push(function () {
                    OneSignal.getUserId(function (userId) {
                        localStorage.setItem('id_one_signal', userId)
                    });
                });
            });
        });

    </script>

    {{-- Polyfill JS features via polyfill.io --}}
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>
    <!-- <script type="text/javascript" src="{{secure_asset('js/app.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>

</html>
