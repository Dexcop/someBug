<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .logout-container {
            position: fixed;
            top: 0;
            right: 0;
            padding: 10px;
        }

        body {
            padding-top: 40px;
        }
    </style>
</head>

<body>
    <div class="logout-container">
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <div class="container mt-4">
        @if (session('data') && count(session('data')) > 0)
            @foreach (session('data') as $item)
                <div class="col-4 mb-3 mt-3">
                    <div class="card" style="width: 18rem;">
                        @if ($item->image)
                            <img class="card-img-top" src="{{ asset('storage/images/' . $item->image) }}"
                                alt="Card image cap" style="width: 18rem; height: 15rem;">
                        @else
                            <img class="card-img-top" src="{{ asset('assets/asus.jpg') }}" alt="Card image cap"
                                style="width: 18rem; height: 15rem;">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text text-secondary" style="font-size: 12px; font-style: italic;">Category:
                                {{ $item->category }}</p>
                            <p class="card-text text-secondary" style="font-size: 12px; font-style: italic;">Price: Rp.{{ $item->price }}</p>
                            <p class="card-text text-secondary" style="font-size: 12px; font-style: italic;">Quantity:
                                {{ $item->quantity }}</p>
                            <div class="d-flex justify-content-around">
                                <a href="/cart/{{ $item->id }}" class="btn btn-success">Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No data available!</p>
        @endif
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>