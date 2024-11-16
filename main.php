<?php

if ($page_id == 1) {
    echo $app_list_section;
} elseif ($page_id == 2) {
    echo $profile_section;
} elseif ($page_id == 3) {
    // echo $profile_section;
}


?>



<section id="caller_id">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div id="search_form">
                    <div class="card">
                        <div class="card-header">Search Box</div>
                        <div class="card-body">
                            <form id="search_form" class="row g-3" method="get" enctype="multipart/form-data">
                                <div>
                                    <input class="form-control" type="number" name="number" placeholder="01x xxxx-xxxx" value=<?php echo $number;?>>
                                </div>
                                <div>
                                    <input class="form-control" type="text" name="name" placeholder="Name here..." value="<?php echo $name; ?>">
                                </div>
                                <div>
                                    <select name="relative" class="form-control">
                                        <?php echo $options; 
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <button class="btn btn-outline-danger" onclick="document.getElementById('search_form').reset();">Reset</button>
                                    <input class="btn btn-outline-success" name="submit" type="submit" value="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="search_result">
                    <div class="card">
                        <div class="card-header">Result</div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead class="table-success">
                                    <tr class="">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Relative</th>
                                    </tr>
                                </thead>
                                <tbody class="data-sheet-body">
                                    <?php echo $table_data; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>