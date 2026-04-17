<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>All Complaints</h2>

<a href="/admin/complaints">All</a> |
<a href="/admin/complaints?status=Pending">Pending</a> |
<a href="/admin/complaints?status=Resolved">Resolved</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Ticket</th>
        <th>Name</th>
        <th>Message</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach($complaints as $c): 

$isDelayed = (
    strtotime($c['created_at']) < strtotime('-48 hours') 
    && $c['status'] == 'Pending'
);

?>
    <tr style="<?= $isDelayed ? 'background-color: #ffe6e6;' : '' ?>">
        <td><?= $c['id'] ?></td>
        <td><?= $c['ticket_number'] ?? 'N/A' ?></td>
        <td><?= esc($c['name']) ?></td>
        <td><?= esc($c['message']) ?></td>
        <td>
    <?php if($c['status'] == 'Pending'): ?>
        <span style="color:red;">Pending</span>
    <?php else: ?>
        <span style="color:green;">Resolved</span>
    <?php endif; ?>
</td>
        <td>
            <a href="/admin/complaints/view/<?= $c['id'] ?>">View</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>