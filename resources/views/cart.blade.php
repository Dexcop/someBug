<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            padding-top: 40px;
        }

        .home-container {
            position: fixed;
            top: 0;
            left: 0;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="home-container">
        <form action="/dashboard" method="GET">
            @csrf
            <button type="submit" class="btn btn-secondary">Back</button>
        </form>
    </div>
    <div class="container mt-4">
        <form action="{{ route('buy.confirmation', ['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- @method('PATCH') --}}
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name: {{ $data->name }}</label>
                <input type="hidden" name="itemName" value="{{ $data->name }}">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Category: {{ $data->category }}</label>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Price</label>
                <input type="hidden" name="totalPrice" value="{{ $data->price    }}">
                <div class="input-group">
                    <span class="input-group-text">Rp. {{ $data->price }}</span>
                </div>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                    id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $data->quantity }}">
                @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image: </label>
                @if ($data->image)
                    <img class="card-img-top" src="{{ asset('storage/images/' . $data->image) }}" alt="Card image cap"
                        style="width: 18rem; height: 15rem;">
                @else
                    <img class="card-img-top" src="{{ asset('assets/asus.jpg') }}" alt="Card image cap"
                        style="width: 18rem; height: 15rem;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>