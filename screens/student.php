<?php
session_start();
include '../includes/db.php';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit < 1) $limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

function getPaginationUrl($pageNum, $limit) {
    $params = $_GET;
    $params['page'] = $pageNum;
    $params['limit'] = $limit;
    return '?' . http_build_query($params);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
       integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <title>Student Catalog - Library Zone</title>
</head>
<body class="bg-light">
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-5">
        <!-- Advanced Filter (Fully Restored) -->
        <div class="card shadow-sm border-0 rounded-lg mb-5">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">🔍 Advanced Filter</h4>
                <form method="get" class="form-inline m-0">
                    <?php
                    foreach ($_GET as $key => $value) {
                        if ($key != 'limit' && $key != 'page') {
                            echo '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($value).'">';
                        }
                    }
                    ?>
                    <label for="limit" class="mr-2 font-weight-bold text-white">Items per page:</label>
                    <select name="limit" id="limit" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="5" <?php echo $limit == 5 ? 'selected' : ''; ?>>5</option>
                        <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="20" <?php echo $limit == 20 ? 'selected' : ''; ?>>20</option>
                        <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                </form>
            </div>
            <div class="card-body bg-light p-4">
                <form id="libraryForm" class="ajax-filter-form" method="get" action="student.php" novalidate>
                    <input type="hidden" name="limit" value="<?php echo htmlspecialchars($limit); ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bookName" class="col-sm-3 col-form-label font-weight-bold">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" placeholder="Book title" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="author" class="col-sm-3 col-form-label font-weight-bold">Author</label>
                                <div class="col-sm-9">
                                    <input type="text" name="author" class="form-control" placeholder="Author name" value="<?php echo isset($_GET['author']) ? htmlspecialchars($_GET['author']) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="publication" class="col-sm-3 col-form-label font-weight-bold">Publication</label>
                                <div class="col-sm-9">
                                    <input type="text" name="publication" class="form-control" placeholder="Publication" value="<?php echo isset($_GET['publication']) ? htmlspecialchars($_GET['publication']) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="edition" class="col-sm-3 col-form-label font-weight-bold">Edition</label>
                                <div class="col-sm-9">
                                    <input type="text" name="edition" class="form-control" placeholder="Edition" value="<?php echo isset($_GET['edition']) ? htmlspecialchars($_GET['edition']) : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="class" class="col-sm-3 col-form-label font-weight-bold">Class</label>
                                <div class="col-sm-9">
                                    <select name="class" id="class" class="form-control">
                                        <option value="#">Select Class</option>
                                        <?php 
                                        $classes = ['fybcs', 'sybcs', 'fybca', 'sybca', 'tybca'];
                                        foreach($classes as $c) {
                                            $selected = (isset($_GET['class']) && $_GET['class'] == $c) ? 'selected' : '';
                                            echo "<option value=\"$c\" $selected>".strtoupper($c)."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-sm-3 col-form-label font-weight-bold">Semester</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <div class="form-check mr-4">
                                        <input type="radio" class="form-check-input" id="radio0" name="sem" value="" <?php echo (!isset($_GET['sem']) || $_GET['sem'] == '') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="radio0">All</label>
                                    </div>
                                    <div class="form-check mr-4">
                                        <input type="radio" class="form-check-input" id="radio1" name="sem" value="I" <?php echo (isset($_GET['sem']) && $_GET['sem'] == 'I') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="radio1">Sem 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="radio2" name="sem" value="II" <?php echo (isset($_GET['sem']) && $_GET['sem'] == 'II') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="radio2">Sem 2</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="text-right">
                        <a href="student.php" class="btn btn-outline-secondary px-4 mr-2">Clear</a>
                        <button type="submit" class="btn btn-warning font-weight-bold px-5" name="sbmt">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>



        <div id="student-catalog-card" class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                <h5 class="mb-0 text-dark"><i class="fas fa-book"></i> Library Books Catalog</h5>
                
                <form class="form-inline m-0 ajax-filter-form" method="get" id="catalogControls">
                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-md-3">
                        <label class="mr-2 small font-weight-bold">Show</label>
                        <select name="limit" class="form-control form-control-sm">
                            <?php 
                                $limits = [5, 10, 20, 50, 100];
                                foreach($limits as $l) {
                                    echo '<option value="'.$l.'" '.($limit == $l ? 'selected' : '').'>'.$l.'</option>';
                                }
                            ?>
                        </select>
                        <label class="ml-2 small font-weight-bold">rows</label>
                    </div>
                    
                    <div class="input-group input-group-sm shadow-sm">
                        <input class="form-control border-warning" type="search" name="search" placeholder="Search Books..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-warning text-dark font-weight-bold px-3" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
            <?php
            // Combined Filter Logic
            $conditions = array();
            $params_arr = array();

            // 1. Simple Search
            if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                $s = mysqli_real_escape_string($con, $_GET['search']);
                $conditions[] = "(name LIKE '%$s%' OR author LIKE '%$s%' OR publication LIKE '%$s%' OR edition LIKE '%$s%' OR class LIKE '%$s%')";
                $params_arr['search'] = $_GET['search'];
            }

            // 2. Advanced Fields
            if (isset($_GET['name']) && !empty(trim($_GET['name']))) {
                $n = mysqli_real_escape_string($con, $_GET['name']);
                $conditions[] = "name LIKE '%$n%'";
                $params_arr['name'] = $_GET['name'];
            }
            if (isset($_GET['author']) && !empty(trim($_GET['author']))) {
                $a = mysqli_real_escape_string($con, $_GET['author']);
                $conditions[] = "author LIKE '%$a%'";
                $params_arr['author'] = $_GET['author'];
            }
            if (isset($_GET['publication']) && !empty(trim($_GET['publication']))) {
                $p = mysqli_real_escape_string($con, $_GET['publication']);
                $conditions[] = "publication LIKE '%$p%'";
                $params_arr['publication'] = $_GET['publication'];
            }
            if (isset($_GET['edition']) && !empty(trim($_GET['edition']))) {
                $e = mysqli_real_escape_string($con, $_GET['edition']);
                $conditions[] = "edition LIKE '%$e%'";
                $params_arr['edition'] = $_GET['edition'];
            }
            if (isset($_GET['class']) && !empty(trim($_GET['class'])) && $_GET['class'] != '#') {
                $c = mysqli_real_escape_string($con, $_GET['class']);
                $conditions[] = "class = '$c'";
                $params_arr['class'] = $_GET['class'];
            }
            if (isset($_GET['sem']) && !empty(trim($_GET['sem']))) {
                $sem = mysqli_real_escape_string($con, $_GET['sem']);
                $conditions[] = "sem = '$sem'";
                $params_arr['sem'] = $_GET['sem'];
            }

            $searchQuery = count($conditions) > 0 ? " WHERE " . implode(' AND ', $conditions) : "";
            $searchParam = !empty($params_arr) ? "&" . http_build_query($params_arr) : "";
            
            $limitParam = "&limit=" . $limit;
            
            // Get total rows
            $total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM `bookdata`" . $searchQuery);
            $total_row = mysqli_fetch_assoc($total_query);
            $total_pages = ceil($total_row['total'] / $limit);

            $q = "SELECT * FROM `bookdata` " . $searchQuery . " LIMIT $limit OFFSET $offset";
            $query = mysqli_query($con, $q);
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered shadow-sm bg-white mb-0">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th> Name </th>
                            <th> Author </th>
                            <th> Publication </th>
                            <th> Edition </th>
                            <th> Class </th>
                            <th> Semester </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php
                        if(mysqli_num_rows($query) > 0) {
                            while($res = mysqli_fetch_array($query)){
                            ?>
                            <tr>
                                <td class="align-middle"> <?php echo htmlspecialchars($res['name']) ?> </td>
                                <td class="align-middle"> <?php echo htmlspecialchars($res['author']) ?> </td>
                                <td class="align-middle"> <?php echo htmlspecialchars($res['publication']) ?> </td>
                                <td class="align-middle"> <?php echo htmlspecialchars($res['edition']) ?> </td>
                                <td class="align-middle"> <?php echo htmlspecialchars($res['class']) ?> </td>
                                <td class="align-middle"> <?php echo htmlspecialchars($res['sem']) ?> </td>
                            </tr>
                            <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center text-muted py-4">No books found matching your search.</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>

            </div>
            <?php if($total_pages > 1): ?>
            <div class="card-footer bg-white py-3 d-flex justify-content-center" id="student-pagination">
                <nav aria-label="Student catalog pagination">
                    <ul class="pagination mb-0 shadow-sm">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?page='.($page - 1).$searchParam.$limitParam; ?>">Previous</a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i.$searchParam.$limitParam; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page + 1).$searchParam.$limitParam; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
        

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateTable = (targetId, url) => {
                const card = document.getElementById(targetId);
                if (!card) return;
                
                const tbody = card.querySelector('tbody');
                const paginationId = 'student-pagination';
                const pagination = document.getElementById(paginationId);
                
                if (tbody) tbody.style.opacity = '0.5';
                
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newCard = doc.getElementById(targetId);
                        if (newCard) {
                            const newTbody = newCard.querySelector('tbody');
                            const newPagination = doc.getElementById(paginationId);
                            
                            if (newTbody && tbody) {
                                tbody.innerHTML = newTbody.innerHTML;
                                tbody.style.opacity = '1';
                            }
                            if (newPagination && pagination) {
                                pagination.innerHTML = newPagination.innerHTML;
                                pagination.style.display = newPagination.style.display;
                            }
                        }
                        window.history.pushState({path: url}, '', url);
                    })
                    .catch(err => {
                        console.error('AJAX Update failed:', err);
                        if (tbody) tbody.style.opacity = '1';
                    });
            };

            // 1. Pagination Clicks
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.page-link');
                if (!link) return;
                e.preventDefault();
                const url = link.getAttribute('href');
                if (!url || url === '#') return;
                updateTable('student-catalog-card', url);
            });

            // 2. Filter/Limit Changes
            document.addEventListener('change', function(e) {
                const form = e.target.closest('.ajax-filter-form');
                if (!form) return;
                const formData = new FormData(form);
                const params = new URLSearchParams(window.location.search);
                for (const [key, value] of formData.entries()) {
                    if (value !== '') params.set(key, value);
                    else params.delete(key);
                }
                const url = window.location.pathname + '?' + params.toString();
                updateTable('student-catalog-card', url);
            });

            // 3. Search Submits
            document.addEventListener('submit', function(e) {
                const form = e.target.closest('.ajax-filter-form');
                if (!form) return;
                e.preventDefault();
                const formData = new FormData(form);
                const params = new URLSearchParams(window.location.search);
                for (const [key, value] of formData.entries()) {
                    if (value !== '') params.set(key, value);
                    else params.delete(key);
                }
                params.delete('page');
                const url = window.location.pathname + '?' + params.toString();
                updateTable('student-catalog-card', url);
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
