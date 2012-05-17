<?php
/* Copyright (C) 2011 clueless <clueless@thunked.org>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
/**
 *
 */
class IPAddress
{

    const ip46_prefix = "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff\xff";
    
    const prefer_v4 = 1;
    const prefer_v6 = 2;
    const use_default = 0;
    const mask4 = 32;
    const mask6 = 128;
    
    /**
     * Creates a binary string representation of ip addresses
     *
     * \param $txtip The human readable representation of an IPv6 or IPv4 address.
     *               Example values are 1.2.3.4, ::ffff:1.2.3.4, cafe:babe::dead:beef
     * \param $preference If set to IPAddress::prefer_v6 then IPv4 addresses will be
     *                    be converted to IPv6 addresses and be returned as 16 bytes rather
     *                    than 4.
     *                    If set to IPAddress::prefer_v4 then IPv6 encoded IPv4 addresses will be
     *                    returned as 4 bytes rather than 16 bytes.
     *                    If set to IPAddress::use_default then no conversions will ever be done.
     * \return A binary string that represents the ip address. This is either 4 or 16 bytes
     *         depending on the parameters passed to the function.
     */
    static function ToBinary($txtip, $preference = self::prefer_v6)
    {
        $binip = inet_pton($txtip);
        if(strlen($binip) == 4 && $preference == self::prefer_v6)
            $binip = self::ip46_prefix . $binip;
        elseif(strlen($binip) == 16 && $preference == self::prefer_v4 && ($binip | self::ip46_prefix) == $binip)
            $binip = substr($binip, 12);
        
        return $binip;
    }
    
    /**
     * Creates a human readable representation of binary IP address strings
     *
     * \param $binip 4 or 16 byte binary string representing an IPv4 or IPv6 address
     * \param $preference If set to IPAddress::prefer_v6 then IPv4 addresses will be
     *                    be returned as IPv6 encoded IPv4 addresses
     *                    If set to IPAddress::prefer_v4 then IPv6 encoded IPv4 addresses will be
     *                    returned as plain IPv4 addresses
     *                    If set to IPAddress::use_default then no conversions will ever be done.
     * \return Can be a human readable IPv4 address (1.2.3.4) or an IPv6 address (cafe:babe::dead:beef)
     *         or an IPv6 encoded IPv4 address (::ffff:1.2.3.4)
     */
    static function ToHuman($binip, $preference = self::prefer_v4)
    {
        if(strlen($binip) == 4 && $preference == self::prefer_v6)
            $binip = self::ip46_prefix . $binip;
        else if(strlen($binip) == 16 && $preference == self::prefer_v4 && ($binip | self::ip46_prefix) == $binip)
            $binip = substr($binip, 12);

        return inet_ntop($binip);
    }
     
    /**
     * Create an IP network mask as a binary string
     *
     * \param $netbits The # of bits in the network part of the address  (see CIDR notation)
     * \param $maxbits Set this to IPAddress::mask6 for an IPv6 netmask and IPAddress::mask4
     *                 for an IPv4 netmask
     * \return The binary string representation of the netmask.
     */
    static function CreateMask($netbits, $maxbits = self::mask6)
    {
        $bits = str_repeat('1', $netbits) . str_repeat('0', $maxbits - $netbits);
        $bytes = '';

        for($i = 0; $i < $maxbits; $i += 8)
            $bytes .= chr(bindec(substr($bits, $i, 8)));

        return $bytes;
    }
}
