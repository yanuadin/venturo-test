<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!-- CSRF Token -->
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>
</head>
    <body class="bg-white">
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body bg-white">
                <form action="{{ route('sales-report.index') }}" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <option value="2021" {{ $year == 2021 ? 'selected'  : ''}}>2021</option>
                                    <option value="2022" {{ $year == 2022 ? 'selected'  : ''}}>2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                            <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu" class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2021" target="_blank" rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                            <a href="https://tes-web.landa.id/intermediate/download?path=example.php" class="btn btn-secondary">Download Example</a>
                        </div>
                    </div>
                </form>
                <hr>
                @if($isValidYear)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="margin: 0;">
                            <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                <th colspan="12" style="text-align: center;">Periode Pada {{ $year }}
                                </th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                            </tr>
                            <tr class="table-dark">
                                <th style="text-align: center;width: 75px;">Jan</th>
                                <th style="text-align: center;width: 75px;">Feb</th>
                                <th style="text-align: center;width: 75px;">Mar</th>
                                <th style="text-align: center;width: 75px;">Apr</th>
                                <th style="text-align: center;width: 75px;">Mei</th>
                                <th style="text-align: center;width: 75px;">Jun</th>
                                <th style="text-align: center;width: 75px;">Jul</th>
                                <th style="text-align: center;width: 75px;">Ags</th>
                                <th style="text-align: center;width: 75px;">Sep</th>
                                <th style="text-align: center;width: 75px;">Okt</th>
                                <th style="text-align: center;width: 75px;">Nov</th>
                                <th style="text-align: center;width: 75px;">Des</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $key => $values)
                                <tr>
                                    <td class="table-secondary" colspan="14"><b>{{ ucwords($key) }}</b></td>
                                </tr>
                                @foreach($values as $value)
                                    <tr>
                                        <td class="bg-white">{{ $value['menu'] }}</td>
                                        @foreach($value['subtotal'] as $total)
                                            <td style="text-align: right;" class="bg-white">
                                                {{ $total === 0 ? '' : number_format($total) }}
                                            </td>
                                        @endforeach
                                        <td class="bg-white" style="text-align: right;"><b>{{ number_format($value['total']) }}</b></td>
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr class="table-dark">
                                <td><b>Total</b></td>
                                @foreach($summaryMonths as $summaryMonth)
                                    <td style="text-align: right;">
                                        <b>{{ $summaryMonth === 0 ? '' : number_format($summaryMonth) }}</b>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <?php if(isset($menu)){?>

            <div class="row m-3">
                <div class="col-6"><h4>Isi Json Menu</h4><pre style="height: 400px; background:#eaeaea;">0</pre></div>
                <div class="col-6"><h4>Isi Json Transaksi</h4><pre style="height: 400px; background:#eaeaea;">0</pre></div>
            </div>
            <?php }?>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
