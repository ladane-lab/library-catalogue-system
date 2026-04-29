<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: faculty.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <title>Staff Dashboard - Library Zone</title>
</head>
<body class="bg-light">
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container-fluid mt-4">
        <!-- Books List Section -->
        <div id="staff-catalog-card" class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                <h5 class="mb-0 text-dark"><i class="fas fa-book"></i> Library Books Catalog 
                    <span id="selected-count" class="badge badge-primary ml-2" style="<?php echo (empty($_SESSION['selected_books']) ? 'display:none;' : ''); ?>">
                        <?php echo count($_SESSION['selected_books'] ?? []); ?> selected
                    </span>
                </h5>
                <form class="form-inline m-0 ajax-filter-form" method="get" id="catalogControls">
                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-md-3">
                        <label class="mr-2 small font-weight-bold">Show</label>
                        <select name="limit" class="form-control form-control-sm">
                            <?php 
                                $limits = [5, 10, 20, 50, 100];
                                $current_limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
                                foreach($limits as $l) {
                                    echo '<option value="'.$l.'" '.($current_limit == $l ? 'selected' : '').'>'.$l.'</option>';
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
                    if(isset($_SESSION['status'])) {
                        echo '<div class="alert alert-success m-3 alert-dismissible fade show" role="alert">
                                '.htmlspecialchars($_SESSION['status']).'
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                        unset($_SESSION['status']);
                    }
                ?>
                <form method="post" action="../scripts/save.php" id="updateForm">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>Select</th>
                                    <th>ISBN</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>EDN</th>
                                    <th>Price</th>
                                    <th>Edition</th>
                                    <th>Qty</th>
                                    <th>YOP</th>
                                </tr>
                            </thead>
                            <tbody id="staff-catalog-tbody">
                            <?php
                                // Pagination and Search logic
                                $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 5; 
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                                $offset = ($page - 1) * $limit;

                                $searchQuery = "";
                                $searchParam = "";
                                if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                                    $search = mysqli_real_escape_string($con, $_GET['search']);
                                    $searchQuery = " WHERE isbn LIKE '%$search%' OR author LIKE '%$search%' OR title LIKE '%$search%' OR edn LIKE '%$search%' OR price LIKE '%$search%' OR edition LIKE '%$search%' OR qty LIKE '%$search%' OR yop LIKE '%$search%'";
                                    $searchParam = "&search=" . urlencode($_GET['search']);
                                }
                                
                                $limitParam = "&limit=" . $limit;

                                // Get total rows
                                $total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM `new`" . $searchQuery);
                                $total_row = mysqli_fetch_assoc($total_query);
                                $total_pages = ceil($total_row['total'] / $limit);

                                $q = "SELECT * FROM `new` " . $searchQuery . " LIMIT $limit OFFSET $offset";
                                $query = mysqli_query($con, $q);
                                
                                if(mysqli_num_rows($query) > 0) {
                                    while($res = mysqli_fetch_array($query)){
                                ?>
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <div class="custom-control custom-checkbox">
                                                <?php 
                                                    $isChecked = (isset($_SESSION['selected_books']) && in_array($res['id'], $_SESSION['selected_books'])) ? 'checked' : '';
                                                ?>
                                                <input type="checkbox" class="custom-control-input selection-checkbox" id="check_<?php echo $res['id']; ?>" name="brands[]" value="<?php echo htmlspecialchars($res['id']); ?>" <?php echo $isChecked; ?>>
                                                <label class="custom-control-label" for="check_<?php echo $res['id']; ?>"></label>
                                            </div>
                                        </td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['isbn']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['author']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['title']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['edn']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['price']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['edition']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['qty']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($res['yop']); ?></td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center text-muted py-4">No records found.</td></tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
                        <!-- Pagination UI -->
                        <?php if($total_pages > 1): ?>
                        <nav aria-label="Catalog pagination" id="staff-pagination">
                            <ul class="pagination mb-0 shadow-sm">
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link font-weight-bold" href="<?php echo ($page <= 1) ? '#' : '?page='.($page - 1).$searchParam.$limitParam; ?>" tabindex="-1">Previous</a>
                                </li>
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i.$searchParam.$limitParam; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link font-weight-bold" href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page + 1).$searchParam.$limitParam; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                        <?php else: ?>
                        <div></div>
                        <?php endif; ?>

                        <button type="button" onclick="confirmUpdate()" class="btn btn-primary font-weight-bold px-4 shadow-sm">
                            <i class="fas fa-save"></i> Update Selected
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Sent Books Section -->
        <div id="sent-books-card" class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-success text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                <h5 class="mb-3 mb-md-0"><i class="fas fa-check-circle"></i> Sent Books History</h5>
                
                <form class="form-inline m-0 ajax-filter-form" method="get" id="historyControls">
                    <div class="d-flex align-items-center mb-2 mb-md-0 mr-md-3">
                        <label class="mr-2 small font-weight-bold">Show</label>
                        <select name="limit2" class="form-control form-control-sm">
                            <?php 
                                $limits = [5, 10, 20, 50, 100];
                                $current_limit2 = isset($_GET['limit2']) ? (int)$_GET['limit2'] : 5;
                                foreach($limits as $l) {
                                    echo '<option value="'.$l.'" '.($current_limit2 == $l ? 'selected' : '').'>'.$l.'</option>';
                                }
                            ?>
                        </select>
                        <label class="ml-2 small font-weight-bold">rows</label>
                    </div>
                    <div class="input-group input-group-sm shadow-sm">
                        <input class="form-control border-light" type="search" name="search2" placeholder="Search history..." aria-label="Search History" value="<?php echo isset($_GET['search2']) ? htmlspecialchars($_GET['search2']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-light text-success font-weight-bold px-3" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>ISBN</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>EDN</th>
                                <th>Price</th>
                                <th>Edition</th>
                                <th>Qty</th>
                                <th>YOP</th>
                            </tr>
                        </thead>
                        <tbody id="sent-books-tbody">
                        <?php
                            // Pagination and Search for Sent Books
                            $limit2 = isset($_GET['limit2']) && is_numeric($_GET['limit2']) ? (int)$_GET['limit2'] : 5;
                            $page2 = isset($_GET['p2']) && is_numeric($_GET['p2']) ? (int)$_GET['p2'] : 1;
                            $offset2 = ($page2 - 1) * $limit2;
                            $limitParam2 = "&limit2=" . $limit2;

                            $current_staff = mysqli_real_escape_string($con, $_SESSION['username']);
                            $where_clause = " WHERE sent_by = '$current_staff' ";
                            
                            $searchParam2 = "";
                            if (isset($_GET['search2']) && !empty(trim($_GET['search2']))) {
                                $search2 = mysqli_real_escape_string($con, $_GET['search2']);
                                $where_clause .= " AND (isbn LIKE '%$search2%' OR author LIKE '%$search2%' OR title LIKE '%$search2%' OR edition LIKE '%$search2%') ";
                                $searchParam2 = "&search2=" . urlencode($_GET['search2']);
                            }
                            $params2 = $searchParam2 . $limitParam2;

                            $total_query2 = mysqli_query($con, "SELECT COUNT(*) as total FROM `books`" . $where_clause);
                            $total_row2 = mysqli_fetch_assoc($total_query2);
                            $total_pages2 = ceil($total_row2['total'] / $limit2);

                            $q2 = "SELECT * FROM `books`" . $where_clause . " ORDER BY id DESC LIMIT $limit2 OFFSET $offset2";
                            $query2 = mysqli_query($con, $q2);
                            
                            if(mysqli_num_rows($query2) > 0) {
                                while($res2 = mysqli_fetch_array($query2)){
                            ?>
                                <tr class="text-center">
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['isbn']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['author']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['title']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['edn']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['price']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['edition']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['qty']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($res2['yop']); ?></td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-muted py-4">No sent books yet.</td></tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white py-3 d-flex justify-content-center" id="sent-pagination">
                    <?php if($total_pages2 > 1): ?>
                    <nav aria-label="Sent books pagination">
                        <ul class="pagination mb-0 shadow-sm">
                            <li class="page-item <?php echo ($page2 <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo ($page2 <= 1) ? '#' : '?p2='.($page2 - 1).$params2; ?>">Previous</a>
                            </li>
                            <?php for($j = 1; $j <= $total_pages2; $j++): ?>
                                <li class="page-item <?php echo ($page2 == $j) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?p2=<?php echo $j.$params2; ?>"><?php echo $j; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo ($page2 >= $total_pages2) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo ($page2 >= $total_pages2) ? '#' : '?p2='.($page2 + 1).$params2; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            if (confirm("Do you want to update all selected books?")) {
                document.getElementById('updateForm').submit();
            }
        }

        // Selection Management
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('selection-checkbox')) {
                const id = e.target.value;
                const action = e.target.checked ? 'add' : 'remove';
                
                const formData = new FormData();
                formData.append('id', id);
                formData.append('action', action);
                
                fetch('../modules/manage_selection.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('selected-count');
                    if (data.count > 0) {
                        badge.innerText = data.count + ' selected';
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                });
            }
        });

        // Global Dashboard AJAX Handler
        document.addEventListener('DOMContentLoaded', function() {
            const updateTable = (targetId, url) => {
                const card = document.getElementById(targetId);
                if (!card) return;
                
                const tbody = card.querySelector('tbody');
                const paginationId = card.querySelector('[id$="-pagination"]')?.id || (targetId === 'staff-catalog-card' ? 'staff-pagination' : 'sent-pagination');
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
                            const newBadge = doc.getElementById('selected-count');
                            
                            if (newTbody && tbody) {
                                tbody.innerHTML = newTbody.innerHTML;
                                tbody.style.opacity = '1';
                            }
                            if (newPagination && pagination) {
                                pagination.innerHTML = newPagination.innerHTML;
                                pagination.style.display = newPagination.style.display;
                            }
                            if (newBadge && document.getElementById('selected-count')) {
                                document.getElementById('selected-count').innerHTML = newBadge.innerHTML;
                                document.getElementById('selected-count').style.display = newBadge.style.display;
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
                const card = link.closest('.card');
                if (card && card.id) updateTable(card.id, url);
            });

            // 2. Filter/Limit Changes
            document.addEventListener('change', function(e) {
                const form = e.target.closest('.ajax-filter-form');
                if (!form) return;
                const card = form.closest('.card');
                if (!card || !card.id) return;
                const formData = new FormData(form);
                const params = new URLSearchParams(window.location.search);
                for (const [key, value] of formData.entries()) {
                    if (value !== '') params.set(key, value);
                    else params.delete(key);
                }
                const url = window.location.pathname + '?' + params.toString();
                updateTable(card.id, url);
            });

            // 3. Search Submits
            document.addEventListener('submit', function(e) {
                const form = e.target.closest('.ajax-filter-form');
                if (!form) return;
                e.preventDefault();
                const card = form.closest('.card');
                if (!card || !card.id) return;
                const formData = new FormData(form);
                const params = new URLSearchParams(window.location.search);
                for (const [key, value] of formData.entries()) {
                    if (value !== '') params.set(key, value);
                    else params.delete(key);
                }
                const tableNum = card.id.includes('staff') ? 'page' : 'p2';
                params.delete(tableNum);
                const url = window.location.pathname + '?' + params.toString();
                updateTable(card.id, url);
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
