<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page Not Found</title>
        <link rel="stylesheet" href="/css/all.css" >

        <script>
            (function() {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
        </script>
    </head>
    <body>
        <div class="container">	
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                <div class="_text_center">You don't have enough permission to access this page</div>
            </div>
        </div>
    </body>
</html>
