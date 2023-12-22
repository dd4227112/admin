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
                $directory='/usr/share/nginx/html/admin/storage/schema_backups/2023-12-212040';
                $file = scandir($directory);

                // Remove . and .. from the list (current directory and parent directory)
                $files = array_diff($file, array('.', '..'));

                // Display the list of filenames
                foreach ($files as $file) {
             
                    ?>
                    <tr>
                        <td>{{$file}}</td>
                        <td><a href="https://admin.shulesoft.africa/storage/schema_backups/<?= $file ?>">Download</a></td>

                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>