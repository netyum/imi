<?php
namespace Imi\Model\Annotation\Relation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;

/**
 * 关联左侧字段
 * @Annotation
 * @Target("PROPERTY")
 * @Parser("Imi\Model\Parser\RelationParser")
 */
class JoinFrom extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected ?string $defaultFieldName = 'field';

    /**
     * 字段名
     *
     * @var string
     */
    public $field;

}