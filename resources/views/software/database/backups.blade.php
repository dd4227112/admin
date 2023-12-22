<div class="card-block">
    <div class="table-responsive">
        <table class="table dataTable table-bordered nowrap">
            <thead>
                <tr>
                    <th>school</th>
                    <th>action</th>
                
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $master_tables=DB::select('select username  as  school,  is_new_version  from  admin.clients  where  status=1  and  is_new_version=0');
                foreach ($master_tables as $table) {
                    ?>
                    <tr>
                        <td>{{$table->school}}</td>
                        <td><a href="https://admin.shulesoft.africa/storage/schema_backups/2023-12-212040.<?=$table->school?>">Download</a></td>
                
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>