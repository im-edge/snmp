<?php

namespace IMEdge\Snmp\DataType;

use Sop\ASN1\Element;
use Sop\ASN1\Type\Primitive\OctetString as AsnType;
use Sop\ASN1\Type\Tagged\ApplicationType;
use Sop\ASN1\Type\UnspecifiedType;

use function bin2hex;

class Opaque extends DataType
{
    protected int $tag = self::OPAQUE;

    final protected function __construct(ApplicationType $app)
    {
        $tag = $this->getTag();
        $binary = $app->asImplicit(Element::TYPE_OCTET_STRING, $tag)->asOctetString()->string();

        parent::__construct($binary);
    }

    public function getReadableValue(): string
    {
        return '0x' . bin2hex(AsnTypeHelper::wantString($this->rawValue));
    }

    public function jsonSerialize(): array
    {
        return [
            'type'  => self::TYPE_TO_NAME_MAP[$this->getTag()],
            'value' => $this->getReadableValue(),
        ];
    }

    public static function fromASN1(UnspecifiedType $element): DataType|static
    {
        return new static($element->asApplication());
    }

    public function toASN1(): Element
    {
        return new AsnType(AsnTypeHelper::wantString($this->rawValue));
    }
}
