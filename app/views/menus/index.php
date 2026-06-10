<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Menu</h1>
        <p style="color: var(--text-gray); font-weight: 600; margin-top: 0.5rem;">Định cấu hình thanh điều hướng hệ thống</p>
    </div>
</div>

<?php flash('menu_message'); ?>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">Thứ tự</th>
                    <th style="width: 25%;">Tên Menu</th>
                    <th style="width: 20%;">Đường dẫn</th>
                    <th style="width: 25%;">Icon hiển thị</th>
                    <th style="width: 15%;">Quyền tối thiểu</th>
                    <th style="width: 10%; text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['menus'] as $menu) : ?>
                <tr>
                    <td><strong><?php echo $menu->sort_order; ?></strong></td>
                    <td><strong style="color: var(--primary);"><?php echo $menu->name; ?></strong></td>
                    <td><code><?php echo $menu->url; ?></code></td>
                    <td><i class="<?php echo $menu->icon; ?>" style="color: var(--secondary); margin-right: 8px;"></i> <?php echo $menu->icon; ?></td>
                    <td>
                        <span style="background: #eef2ff; color: #4f46e5; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">
                            <?php echo $menu->min_role_name ?? 'Không giới hạn'; ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="<?php echo URLROOT; ?>/menus/edit/<?php echo $menu->id; ?>" class="btn-action edit"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
