<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="card text-center py-5">
    <h1 style="font-weight: 800; font-size: 2.5rem; margin-bottom: 1.5rem;"><?php echo $data['title']; ?></h1>
    <p style="font-size: 1.2rem; color: var(--text-gray); margin-bottom: 2.5rem;"><?php echo $data['description']; ?></p>
    <div>
        <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-primary btn-lg">Bắt đầu làm việc ngay <i class="fas fa-arrow-right"></i></a>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
