@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12 col-lg-8 col-sm-12 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">Weekly Requests</h3>
            <div id="ct-visits" style="height: 405px;">
                <div class="chartist-tooltip" style="top: 257px; left: 230px;"></div>
                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
                <style type="text/css">
                    ${demo.css}
                </style>
                <script type="text/javascript">
                    $(function () {
                        $('#container').highcharts({
                            data: {
                                table: 'datatable'
                            },
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Log requests in weekly interval'
                            },
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: 'Requests'
                                }
                            },
                            tooltip: {
                                formatter: function () {
                                    return '<b>' + this.series.name + '</b><br/>' +
                                            this.point.y + ' ' + this.point.name.toLowerCase();
                                }
                            }
                        });
                    });
                </script>
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/data.js"></script>
                <script src="https://code.highcharts.com/modules/exporting.js"></script>

                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                <?php
                $date = date_create(date('Y-m-d'));
                ?>
                <table id="datatable" style="display:none">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Parents</th>
                            <th>Teachers</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i <= 5; $i++) {
                            date_sub($date, date_interval_create_from_date_string($i . ' days'));
                            $day = date('l', strtotime(date_format($date, 'Y-m-d')));
                            $query = \DB::select('select "user", count(*) from '.$schema.'.log where created_at::date=\'' . date_format($date, 'Y-m-d') . '\' group by "user"');
                            $user['parent'] = array();
                            $user['teacher'] = array();
                            $user['admin'] = array();
                            foreach ($query as $q) {
                                if ($q->user == 'Parent')
                                    array_push($user['parent'], $q->count);
                                if ($q->user == 'Teacher')
                                    array_push($user['teacher'], $q->count);
                                if ($q->user == 'Admin')
                                    array_push($user['admin'], $q->count);
                            }
                            ?>
                            <tr>
                                <th><?= $day ?></th>
                                <td><?= isset($user['parent'][0]) ? $user['parent'][0] : 0 ?></td>
                                <td><?= isset($user['teacher'][0]) ? $user['teacher'][0] : 0 ?></td>
                                <td><?= isset($user['admin'][0]) ? $user['admin'][0] : 0 ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4 col-sm-12 col-xs-12">
        <div class="panel">
            <div class="p-20">
                <div class="row">
                    <div class="col-xs-8">
                        <h4 class="m-b-0"><?= date('d M Y')?> Requests</h4>
                        <h2 class="m-t-0 font-medium">Total: <?= $total->count ?></h2>
                    </div>
                    <div class="col-xs-4 p-20">
                        <select class="form-control">
                            <option>DEC</option>
                            <option>JAN</option>
                            <option>FEB</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer bg-extralight">
                <ul class="earning-box">
                    <?php
                    foreach ($request_by_user as $request) {
                        ?>
                        <li>
                            <div class="er-row">
                                <div class="er-pic"><img src="<?= url('/') . '/public/' ?>plugins/images/users/genu.jpg" alt="varun" width="60" class="img-circle"></div>
                                <div class="er-text"><h3><?= $request->user ?></h3>
                                    <span class="text-muted"><?= date('d M Y') ?></span></div>
                                <div class="er-count "><span class="counter"><?= $request->count ?></span></div>
                            </div>
                        </li>
                    <?php } ?>

                    <li class="center">
                        <a class="btn btn-rounded btn-info btn-block p-10">View Graph</a>
                    </li>
                </ul>
            </div>    
        </div>
    </div>

</div>

@endsection
