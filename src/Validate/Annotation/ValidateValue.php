<?php
namespace Imi\Validate\Annotation;

use Imi\Bean\Annotation;
use Imi\Bean\Annotation\Parser;
use Imi\Bean\Annotation\Base;

/**
 * 验证时的值
 * 
 * @Annotation
 * @Target({"ANNOTATION"})
 * @Parser("\Imi\Validate\Annotation\Parser\ValidateConditionParser")
 */
class ValidateValue extends Base
{
    /**
     * 只传一个参数时的参数名
     * @var string
     */
    protected ?string $defaultFieldName = 'value';

    /**
     * 值规则
     * 
     * 支持代入{:value}原始值
     * 支持代入{:data.xxx}所有数据中的某项
     *
     * @var string
     */
    public $value;

}