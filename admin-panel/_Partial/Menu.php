<?php
    $PageMenu = $_GET['Page'] ?? '';
    $SubMenu  = $_GET['Sub'] ?? '';

    $sidebarMenus = [
        [
            'type' => 'single',
            'icon' => 'bi-grid',
            'label' => 'Dashboard',
            'link' => 'index.php',
            'pages' => ['']
        ],
        [
            'type' => 'group',
            'id' => 'akses-nav',
            'icon' => 'bi-person',
            'label' => 'Akses',
            'pages' => ['AksesFitur', 'AksesEntitas', 'Akses'],
            'children' => [
                ['page' => 'AksesFitur', 'label' => 'Fitur Aplikasi'],
                ['page' => 'AksesEntitas', 'label' => 'Entitas Akses'],
                ['page' => 'Akses', 'label' => 'Akun Akses']
            ]
        ],
        [
            'type' => 'group',
            'id' => 'setting-nav',
            'icon' => 'bi-gear',
            'label' => 'Pengaturan',
            'pages' => ['SettingGeneral', 'SettingEmail'],
            'children' => [
                ['page' => 'SettingGeneral', 'label' => 'Pengaturan Umum'],
                ['page' => 'SettingEmail', 'label' => 'Email Gateway']
            ]
        ],
        [
            'type' => 'group',
            'id' => 'layout-nav',
            'icon' => 'bi-columns',
            'label' => 'Layout',
            'pages' => ['Hero', 'Opening', 'Galeri', 'VisiMisi', 'Pengurus'],
            'children' => [
                ['page' => 'Hero', 'label' => 'Hero/Slider'],
                ['page' => 'Opening', 'label' => 'Opening'],
                ['page' => 'Galeri', 'label' => 'Galeri'],
                ['page' => 'VisiMisi', 'label' => 'Visi Misi'],
                ['page' => 'Pengurus', 'label' => 'Pengurus']
            ]
        ],
        [
            'type' => 'group',
            'id' => 'posting-nav',
            'icon' => 'bi-newspaper',
            'label' => 'Posting',
            'pages' => ['Laman', 'Blog', 'Label', 'Event', 'Testimoni'],
            'children' => [
                ['page' => 'Laman', 'label' => 'Laman'],
                ['page' => 'Blog', 'label' => 'Blog'],
                ['page' => 'Label', 'label' => 'Buku'],
                ['page' => 'Event', 'label' => 'Event'],
                ['page' => 'Testimoni', 'label' => 'Testimoni']
            ]
        ]
    ];
?>
<aside id="sidebar" class="sidebar menu_background">
    <ul class="sidebar-nav" id="sidebar-nav">

        <?php foreach ($sidebarMenus as $menu): ?>
            <?php
                $isActive = in_array($PageMenu, $menu['pages']);
            ?>

            <li class="nav-item">
                <?php if ($menu['type'] === 'single'): ?>
                    <a class="nav-link <?= $isActive ? '' : 'collapsed'; ?>" href="<?= $menu['link']; ?>">
                        <i class="bi <?= $menu['icon']; ?>"></i>
                        <span><?= $menu['label']; ?></span>
                    </a>

                <?php elseif ($menu['type'] === 'group'): ?>
                    <a
                        class="nav-link <?= $isActive ? '' : 'collapsed'; ?>"
                        data-bs-target="#<?= $menu['id']; ?>"
                        data-bs-toggle="collapse"
                        href="javascript:void(0);"
                    >
                        <i class="bi <?= $menu['icon']; ?>"></i>
                        <span><?= $menu['label']; ?></span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>

                    <ul
                        id="<?= $menu['id']; ?>"
                        class="nav-content collapse <?= $isActive ? 'show' : ''; ?>"
                        data-bs-parent="#sidebar-nav"
                    >
                        <?php foreach ($menu['children'] as $child): ?>
                            <li>
                                <a
                                    href="index.php?Page=<?= $child['page']; ?>"
                                    class="<?= $PageMenu === $child['page'] ? 'active' : ''; ?>"
                                >
                                    <i class="bi bi-circle"></i>
                                    <span><?= $child['label']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

        <li class="nav-heading">Fitur Lainnya</li>

        <li class="nav-item">
            <a class="nav-link <?= $PageMenu === 'Newslater' ? '' : 'collapsed'; ?>" href="index.php?Page=Newslater">
                <i class="bi bi-envelope"></i>
                <span>Newslater</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $PageMenu === 'Help' ? '' : 'collapsed'; ?>" href="index.php?Page=Help&Sub=HelpData">
                <i class="bi bi-question"></i>
                <span>Dokumentasi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>
</aside>