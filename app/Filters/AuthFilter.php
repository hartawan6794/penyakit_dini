<?php

namespace App\Filters;

use App\Models\MenuModel;
use App\Models\MenurolesModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use function PHPUnit\Framework\isEmpty;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pastikan helper sudah diload
        helper('settings'); // Ganti 'your_helper_name' dengan nama helper Anda

        // Gunakan fungsi segment() dari helper
        $uri = segment()->getUri();
        $segment = $uri->getSegment(1);
        if (session()->has('logged_in')) {
            // Ambil role ID dari sesi
            $roleModel = new MenurolesModel();
            $menuId = $roleModel->select('id_menu')
                ->where('id_role', session()->get('id_role'))
                ->asArray()
                ->findColumn('id_menu');
            if(!isEmpty($menuId)){
                
            }

            // Ambil menu berdasarkan role ID
            $menuModel = new MenuModel();
            $menus = $menuModel->select('slug')
                ->whereIn('id', $menuId)->asArray()
                ->findColumn('slug');

            if (in_array('user', $menus))
                array_push($menus, 'pasien');
            if (in_array('diagnosis', $menus))
                array_push($menus, 'monitoring');

            array_push($menus, '');
            //  dd($menus);
            if (!in_array($segment, $menus)) {
                echo view('unauthorized');
                exit;
            }
        } else {
            return redirect()->to(base_url('auth'));
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
