<?php
namespace OpenExchangeRates\Dto;

use OpenExchangeRates\Data\DataTransferObjectInterface;

/**
 * Class DataTransferObject
 */
abstract class DataTransferObject implements DataTransferObjectInterface {

    /**
     * DataTransferObject constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->fromResponse($response);
    }


    /**
     * @param array $response
     */
    public function fromResponse(array $response): void
    {
        $arrayObjectProperty = get_class_vars(static::class);
        foreach ($arrayObjectProperty as $key => $property) {
            if (!empty($response[$key])) {
                if (is_array($response[$key])) {
                    $name = $key;
                    $className = 'OpenExchangeRates\Dto\Entity\\'.$name;
                    $this->$key = new $className($response[$key]);
                    continue;
                }

                $this->$key = $response[$key];
            }
        }
    }

}
