<?php
return [
    //Đợt đăng ký
    [
        'name' => 'Xem danh sách đợt đăng ký',
        'code' => 'campaign.index',
        'group' => 'campaign',
    ],
    [
        'name' => 'Thêm đợt đăng ký',
        'code' => 'campaign.create',
        'group' => 'campaign',
    ],
    [
        'name' => 'Sửa đợt đăng ký',
        'code' => 'campaign.edit',
        'group' => 'campaign',
    ],
    [
        'name' => 'Xóa đợt đăng ký',
        'code' => 'campaign.delete',
        'group' => 'campaign',
    ],


    //Vai trò
    [
        'name' => 'Xem danh sách vai trò',
        'code' => 'role.index',
        'group' => 'role'
    ],
    [

        'name' => 'Tạo mới vai trò',
        'code' => 'role.create',
        'group' => 'role'
    ],
    [

        'name' => 'Sửa vai trò',
        'code' => 'role.edit',
        'group' => 'role'
    ],
    [

        'name' => 'Xóa vai trò',
        'code' => 'role.delete',
        'group' => 'role'
    ],

    //Công ty
    [
        'name' => 'Xem danh sách công ty',
        'code' => 'company.index',
        'group' => 'company'
    ],
    [

        'name' => 'Tạo mới công ty',
        'code' => 'company.create',
        'group' => 'company'
    ],
    [

        'name' => 'Sửa công ty',
        'code' => 'company.edit',
        'group' => 'company'
    ],
    [

        'name' => 'Xóa công ty',
        'code' => 'company.delete',
        'group' => 'company'
    ],
    

    //Kế hoạch
    [
        'name' => 'Xem danh sách kế hoạch',
        'code' => 'plan.index',
        'group' => 'plan'
    ],
    [

        'name' => 'Tạo mới kế hoạch',
        'code' => 'plan.create',
        'group' => 'plan'
    ],
    [

        'name' => 'Sửa kế hoạch',
        'code' => 'plan.edit',
        'group' => 'plan'
    ],
    [

        'name' => 'Xóa kế hoạch',
        'code' => 'plan.delete',
        'group' => 'plan'
    ],
    [

        'name' => 'Xem chi tiết kế hoạch',
        'code' => 'plan.show',
        'group' => 'plan'
    ],
    [

        'name' => 'Thêm chi tiết kế hoạch',
        'code' => 'plan.createDetail',
        'group' => 'plan'
    ],
    [

        'name' => 'Sửa chi tiết kế hoạch',
        'code' => 'plan.editDetail',
        'group' => 'plan'
    ],
    [

        'name' => 'Xóa chi tiết kế hoạch',
        'code' => 'plan.deleteDetail',
        'group' => 'plan'
    ],

    //Phân công công ty theo đợt
    [
        'name' => 'Xem danh sách các đợt đăng ký',
        'code' => 'company-campaign.index',
        'group' => 'company-campaign'
    ],
    [
        'name' => 'Xem danh sách công ty trong đợt',
        'code' => 'company-campaign.show',
        'group' => 'company-campaign'
    ],
    [
        'name' => 'Cập nhật thông tin công ty',
        'code' => 'company-campaign.update',
        'group' => 'company-campaign'
    ],
    [
        'name' => 'Thêm hoặc xóa công ty ra khỏi đợt',
        'code' => 'company-campaign.modify',
        'group' => 'company-campaign'
    ],
];