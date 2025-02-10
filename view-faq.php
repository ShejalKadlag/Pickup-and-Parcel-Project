<?php 
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db_connection.php"; // Ensure you have a database connection file

$query = "SELECT fq.id, fmt.topic_name AS main_topic, fst.sub_topic_name AS sub_topic, fq.question, fq.answer 
          FROM faq_questions fq
          JOIN faq_sub_topics fst ON fq.sub_topic_id = fst.id
          JOIN faq_main_topics fmt ON fst.main_topic_id = fmt.id";
$result = $conn->query($query);
?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title d-flex align-items-center gap-3">
                    <span><?= translate('view_faqs') ?></span>
                </h1>
            </div>
        </div>
    </div>
    <div class="reports-table-filters">
        <div class="row g-3">
            <div class="col-12 col-md-3">
                <div class="input-group input-group-sm">
                    <div class="input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input type="search" class="form-control reports-table-search" placeholder="<?= translate('search_here') ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('s_no'); ?></th>
                    <th><?= translate('main_topic'); ?></th>
                    <th><?= translate('sub_topic'); ?></th>
                    <th><?= translate('question'); ?></th>
                    <th><?= translate('answer'); ?></th>
                    <th><?= translate('action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): $s_no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $s_no++; ?></td>
                            <td><?= htmlspecialchars($row['main_topic']); ?></td>
                            <td><?= htmlspecialchars($row['sub_topic']); ?></td>
                            <td><?= htmlspecialchars($row['question']); ?></td>
                            <td><?= htmlspecialchars($row['answer']); ?></td>
                            <td>
                                <a href="edit-faq.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete-faq.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No FAQs found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<script>
    let faqTable = $('#data-table').DataTable({
        lengthChange: true,
        order: [[0, 'asc']],
        initComplete: function() {
            $('.dataTables_filter').hide();
            $('.data-table-search').on('input', function() {
                faqTable.search(this.value).draw();
            });
        }
    });
</script>
