<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework;


class ContainerTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @param string $name
     * @param mixed $value
     *
     * @dataProvider dataParameters
     */
    public function testAddParameter(string $name, $value)
    {
        $container = new Container();
        $container->addParam($name, $value);
        $this->assertSame($value, $container->getParam($name));
    }

    public function testAddParameters()
    {
        $params = [
            'a' => 1,
            'b' => 0.1,
            'c' => true,
            'd' => [1, 2],
            'e' => new \stdClass(),
            'f' => 'abc'
        ];

        $container = new Container();
        $container->addParams($params);

        foreach ($params as $k => $v) {
            $this->assertSame($v, $container->getParam($k));
        }

    }

    public function dataParameters()
    {
        return [
            ['a', 1],
            ['a', 0.1],
            ['a', 'a'],
            ['a', [1, 2]],
            ['a', new \stdClass()],
        ];
    }
}
