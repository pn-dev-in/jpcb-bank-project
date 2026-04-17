<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<h2>Complaint Details</h2>

<p><b>Ticket:</b> <?= $complaint['ticket_number'] ?? 'N/A' ?></p>
<p><b>Name:</b> <?= esc($complaint['name']) ?></p>
<p><b>Email:</b> <?= esc($complaint['email']) ?></p>
<p><b>Phone:</b> <?= esc($complaint['phone']) ?></p>
<p><b>Message:</b> <?= esc($complaint['message']) ?></p>
<p><b>Status:</b> <?= esc($complaint['status']) ?></p>

<hr>

<form method="post" action="/admin/complaints/update/<?= $complaint['id'] ?>">

    <?= csrf_field() ?>

    <!-- STATUS -->
    <label>Update Status:</label>
    <select name="status">
        <option value="Pending" <?= ($complaint['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
        <option value="Resolved" <?= ($complaint['status'] == 'Resolved') ? 'selected' : '' ?>>Resolved</option>
    </select>

    <br><br>

    <!-- 🔥 ASSIGN TO DROPDOWN (PUT HERE) -->
    <label>Assign To:</label>
    <select name="assigned_to">

    <?php 
    $db = \Config\Database::connect();
    $admins = $db->table('admins')->get()->getResultArray();

    foreach($admins as $a): ?>
        <option value="<?= $a['id'] ?>" 
            <?= ($complaint['assigned_to'] == $a['id']) ? 'selected' : '' ?>>
            <?= esc($a['name']) ?>
        </option>
    <?php endforeach; ?>

    </select>

    <br><br>

    <!-- COMMENT -->
    <textarea name="comment" placeholder="Add comment"></textarea>

    <br><br>

    <button type="submit">Update</button>

</form>

<hr>

<!-- 🔥 STATUS HISTORY -->
<h3>Status History</h3>

<ul>
<?php 
$db = \Config\Database::connect();
$logs = $db->table('complaint_logs')
           ->where('complaint_id', $complaint['id'])
           ->orderBy('id', 'DESC')
           ->get()
           ->getResultArray();

foreach($logs as $log): ?>
    <li>
        <b><?= esc($log['status']) ?></b> 
        - <?= esc($log['comment']) ?> 
        - <?= $log['created_at'] ?? '' ?>
    </li>
<?php endforeach; ?>
</ul>

<br>

<a href="/admin/complaints">Back</a>

<?= $this->endSection() ?>