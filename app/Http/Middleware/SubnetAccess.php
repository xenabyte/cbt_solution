<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Log;

class SubnetAccess
{
    public function handle(Request $request, Closure $next)
    {
        $clientIp = $request->ip();
        $subnet = $this->getSubnet($clientIp);

        Log::info($subnet);

        $subnet = '127.0.0.0/24'; // Change this to your desired subnet

        if (!$this->isIpInSubnet($clientIp, $subnet)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

    private function getSubnet($ip)
    {
        $ipParts = explode('.', $ip);
        $subnet = $ipParts[0] . '.' . $ipParts[1] . '.' . $ipParts[2] . '.0/24';

        return $subnet;
    }

    private function isIpInSubnet($ip, $subnet)
    {
        list($subnetAddress, $mask) = explode('/', $subnet);

        $subnetAddress = ip2long($subnetAddress);
        $ip = ip2long($ip);
        $mask = ~((1 << (32 - $mask)) - 1);

        return ($ip & $mask) === ($subnetAddress & $mask);
    }
}
