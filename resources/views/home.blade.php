<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .urls {
            display: flex;
            width: 80%;
            place-content: center;
            place-items: center;
            flex-direction: column;
            font-size: 20px;
        }
        .end-point {
            display: flex;
            gap: 4rem;
            min-width: 40%;
            margin-top: 2rem;
            border: 1px solid black;
            padding: 1rem;
            border-radius: 15px;
            background-color: lightgray;
            box-shadow: 5px 5px 10px gray;
        }
        .content  {
            width: 100%;
        }
        .method {
            min-width: 5rem;
            font-size: 25px;
        }
        .line {
            margin-top: 1rem;
        }
        .font {
            font-family: cursive;
        }
        .description {
            font-style: italic;
        }
        .url {
            background-color: #f1f4f8;
            border-radius: 10px;
            padding-inline: 1rem;
        }

    </style>
</head>
<body style="background-color: #f1f4f8;">
   <div class="info" style="
        display: flex;
        flex-direction: column;
        align-items: center;
    ">
        <h1 style="text-align: center;">Test task API</h1>
        <div class="urls">
            <?php 
                $registerPoint = [
                    'method' => 'post',
                    'url' => '/users/register',
                    'params' => [
                        'required' => ['email', 'userName'],
                        'optional' => ['name']
                    ],
                    'description' => 'Creates a new user'
                ];
                $getPoint = [
                    'method' => 'get',
                    'url' => '/users/{id}',
                    'description' => 'Gets user data'
                ];
                $editPoint = [
                    'method' => 'put',
                    'url' => '/users/{id}',
                    'params' => [
                        'required' => ['userName', 'name'],
                    ],
                    'description' => 'Edits user data'
                ];
                $editPoint2 = [
                    'method' => 'patch',
                    'url' => '/users/{id}',
                    'params' => [
                        'optional' => ['name', 'userName']
                    ],
                    'description' => 'Edits user data'
                ];
                $deletePoint = [
                    'method' => 'delete',
                    'url' => '/users/{id}',
                    'description' => 'Deletes a user'
                ];

                $data = [$registerPoint, $getPoint, $editPoint, $editPoint2, $deletePoint];
            ?>
            @foreach($data as $endPoint) 
                <div class="end-point">
                    <div class="method font">{{ $endPoint['method'] }}</div>
                   <div class="content">
                        <div class="url font">.../api{{ $endPoint['url'] }}</div>
                        @if(array_key_exists('params', $endPoint))
                            <div class="params line">@if(array_key_exists('required', $endPoint['params']))
                                                    <strong>Required: </strong> @foreach ($endPoint['params']['required'] as $param)
                                                        "{{$param}}"
                                                    @endforeach
                                                @endif
                                                @if(array_key_exists('optional', $endPoint['params']))
                                                    <strong>Optional: </strong> @foreach ($endPoint['params']['optional'] as $param)
                                                        "{{$param}}"
                                                    @endforeach
                                                @endif
                                </div>
                        @else
                            <div class="params"> - </div>
                        @endif
                        <div class="description line">{{ $endPoint['description'] }}</div>
                   </div>
                </div>
            @endforeach
        </div>
   </div>
</body>
</html>