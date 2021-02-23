<?php
class Member extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_crud');
        $this->load->model('M_mobile');
    }

    public function index()
    {
        $plg_telp = $this->input->post('plg_notelp');
        $plg_socmed = $this->input->post('plg_socmed');

        $data = '';
        if ($plg_telp || $plg_socmed) {
            $data = [
                'plg_notelp' => $plg_telp,
                'plg_socmed' => $plg_socmed,
            ];
        };

        $this->render_mobile('mobile/v_form_daftar_member', $data);
    }

    public function daftar_member()
    {
        $data = [
            'plg_nama' => $this->input->post('plg_nama'),
            'plg_alamat' => $this->input->post('plg_alamat'),
            'plg_notelp' => $this->input->post('plg_notelp'),
            'plg_socmed' => $this->input->post('plg_socmed'),
            'plg_email' => $this->input->post('plg_email'),
        ];

        $this->M_crud->insert('tmp_member', $data);
        redirect('order');
    }

    public function login_member($out_id)
    {
        $data['out_id'] = $out_id;
        $this->render_mobile('mobile/v_form_member_login', $data);
    }

    public function auth($out_id)
    {
        $plg_telp = $this->input->post('plg_notelp');
        $plg_socmed = $this->input->post('plg_socmed');

        if (!$plg_telp || !$plg_socmed) {
            $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Silahkan isi nomor hp dan akun social media anda.</div>');
            redirect("member/login_member/$out_id/");
        };

        ($plg_telp && $plg_socmed) &&
            $member = $this->M_mobile->check_member('0' . $plg_telp, '@' . $plg_socmed)['plg_id'];

        $encode = md5($member);
        if (isset($member)) {
            redirect("mobile/order/register/$out_id/0/$member/$encode");
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>No hp dan akun social media belum terdaftar</div>');
            redirect("member/login_member/$out_id/");
        }
    }
}
