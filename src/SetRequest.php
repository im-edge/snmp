<?php

namespace IMEdge\Snmp;

class SetRequest extends Pdu
{
    protected bool $wantsResponse = true;

    public function getTag(): int
    {
        return Pdu::SET_REQUEST;
    }
}
