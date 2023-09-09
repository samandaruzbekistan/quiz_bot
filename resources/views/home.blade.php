<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
        .h-custom {
            height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>

<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center  h-100">
            <div class="container">
                <div class="row d-flex justify-content-between align-items-center pt-2 pb-2 mb-3">
                    <div class="col-lg-2"><img src="https://ideal-study.uz/img/logo.png" class="img-fluid" alt=""></div>
                    @if(session('data_error') == 1)
                        <div class="text-danger"><b>Xatolik! Malumotlar notog'ri to'ldirilgan. </b></div>
                    @endif
                    @if(!empty(session('data')))
                        <div class="text-success"><b>Test blocki muvaffaqiyatli kiritildi! </b></div>
                    @endif
                    <div class="col-lg-2"><button class="btn btn-primary" onclick="openForm()">Yangi test +</button></div>
                </div>
                <form action="/add-block" method="post" style="display: none" id="forma">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Test nomini kiriting:</label>
                        <input name="name"  required type="text" class="form-control" id="exampleFormControlInput1" placeholder="Test nomi">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Testlar soni:</label>
                        <input name="count" required type="number" class="form-control" id="exampleFormControlInput1" placeholder="0">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Javoblar:</label>
                        <input required name="answers" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Namuna: abcdaabdaabbcdbda">
                    </div>
                    <button type="submit" class="btn btn-primary">Kiritish</button>
                </form>
                <table class="table" id="jadval">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nomi</th>
                        <th scope="col">Natijalar</th>
                        <th scope="col">Taxrirlash</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blocks as $id => $block)
                    <tr>
                        <th scope="row">{{ $block->id }}</th>
                        <td>{{ $block->name }}</td>
                        <td><a href="{{ route('export', ['id' => $block->id]) }}">Natijalar</a></td>
                        <td><a href="/edit/{{ $block->id }}"><i class="fas fa-edit text-success"></i></a></td>
                        <td>
                            <form action="/delete" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $block->id }}">
                                <button type="submit" class="btn" ><i class="fa fa-trash text-danger"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            Copyright © 2023. Samandar Sariboyev.
        </div>
        <!-- Copyright -->

        <!-- Right -->
        <div>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-google"></i>
            </a>
            <a href="#!" class="text-white">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
        <!-- Right -->
    </div>
</section>
</body>
<script>
    function openForm() {
        document.getElementById('forma').style.display = "block";
        document.getElementById('jadval').style.display = "none";
    }
</script>
</html>
