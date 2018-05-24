<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MoniController extends Controller
{
    /**
     * Stores the server information.
     *
     * @param Request $request
     * @return array
     */
    public function data(Request $request)
    {
        $user = auth('api')->user();

        $server = $user->servers()->where('name', $request->get('server'))->firstOrCreate([
            'name'      => $request->get('server'),
            'os'        => $request->get('os'),
            'version'   => $request->get('version'),
            'node'      => $request->get('node'),
            'processor' => $request->get('processor'),
            'platform'   => $request->get('platform'),
        ]);

        $server->update([
            'os'        => $request->get('os'),
            'version'   => $request->get('version'),
            'node'      => $request->get('node'),
            'processor' => $request->get('processor'),
            'platform'   => $request->get('platform'),
        ]);

        $data = $request->get('data');

        // CPU
        $server->cpus()->updateOrcreate([
            'time_id' => null
        ], [
            'cores'         => $data['cpu']['cores'],
            'percent'       => $data['cpu']['percent'],
            'frequency'     => $data['cpu']['frequency'],
            'min_frequency' => $data['cpu']['min_frequency'],
            'max_frequency' => $data['cpu']['max_frequency']
        ]);

        // Disks
        $server->disks()->where('time_id', null)->delete();

        foreach ($data['disks'] as $key => $disk) {
            $server->disks()->create([
                'device'       => $key,
                'mount_point'   => $disk['mount_point'],
                'file_system'   => $disk['file_system'],
                'total'         => round($disk['total'] * 9.31e-10),
                'used'          => round($disk['used'] * 9.31e-10),
                'free'          => round($disk['free'] * 9.31e-10),
                'percent'       => $disk['percent']
            ]);
        }

        // Mem
        $server->mems()->updateOrcreate([
            'time_id' => null
        ], [
            'total'     => round($data['mem']['total'] * 9.31e-10),
            'available' => round($data['mem']['available'] * 9.31e-10),
            'used'      => round($data['mem']['used'] * 9.31e-10),
            'percent'   => $data['mem']['percent'],
            'free'      => round($data['mem']['free'] * 9.31e-10)
        ]);

        // Net
        $net = $server->nets()->updateOrcreate([
            'time_id' => null
        ], [
            'total' => $data['net']['total'],
            'stable' => $data['net']['stable'],
            'listen' => $data['net']['listen']
        ]);

        $net->addresses()->delete();
        foreach ($data['addresses'] as $key => $address) {
            $net->addresses()->create([
                'name'  => $key,
                'ip'    => $address
            ]);
        }

        // Pid
        $server->pids()->updateOrcreate([
            'time_id' => null
        ],[
            'number' => $data['pids']
        ]);

        return [
            'response' => 'ok'
        ];
    }
}
