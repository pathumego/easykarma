<?php

class packagepacket
{
    public $mainpacketList = array ();

    //-------------------------------------------------------------------------------------

    public function set_InPackagePacket($packagetext)
    {
        $arr_packages = explode("|", $packagetext);

        foreach ($arr_packages as $packet)
        {
            if ($packet != "")
            {
                $obj_mainpacket = new mainpacket();
                $obj_mainpacket->get_incomming_Packet($packet);
                array_push($this->mainpacketList, $obj_mainpacket);
            }
        }
    }

    //-------------------------------------------------------------------------------------

    public function get_OutPackagePacket()
    {
        $obj_mainpacket = new mainpacket();
        $packets = $obj_mainpacket->get_outgoing_Packet();
        $packagePackets = implode("|", $packets);

        return $packagePackets;
    }

    //-------------------------------------------------------------------------------------


}
?>

