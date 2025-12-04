<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Denetim Görüşü</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>
<body>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
              
                <div class="card-body">
                    {!!$data->content!!}
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>