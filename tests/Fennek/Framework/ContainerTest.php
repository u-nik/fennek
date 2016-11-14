<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework;


use Fennek\Framework\Container\FactoryDefinition;
use Fennek\Framework\Exception\ContainerException;
use Fennek\Framework\Exception\NotFoundException;

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
            'f' => 'abc',
        ];

        // Create container with initial parameters
        $container = new Container(['z' => 1]);
        $container->addParams($params);

        foreach ($params as $k => $v) {
            $this->assertSame($v, $container->getParam($k));
        }

        // Check if the initial parameter is still available.
        $this->assertSame(1, $container->getParam('z'));
    }

    public function testParameterConstructorInjection()
    {
        $params = ['a' => 1];

        $container = new Container($params);
        $this->assertSame($params['a'], $container->getParam('a'));
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @dataProvider dataParameters
     */
    public function testGetParameterDefaultValue(string $name, $value)
    {
        $container = new Container();
        $this->assertSame($value, $container->getParam('unknown', $value));
    }

    public function testSetParameters()
    {
        $container = new Container(['a' => 1]);
        $container->setParams(['b' => 2]);

        $this->assertSame(2, $container->getParam('b'));

        // Check if the initial parameter was removed.
        $this->assertNull($container->getParam('a'));
    }

    public function testFluentInterface()
    {
        $container = new Container();
        $this->assertInstanceOf(Container::class, $container->addParam('a', 1));
        $this->assertInstanceOf(Container::class, $container->addParams([]));
        $this->assertInstanceOf(Container::class, $container->setParams([]));
        $this->assertInstanceOf(
            Container::class,
            $container->addDefinition(
                new FactoryDefinition(
                    'id',
                    function () {
                    }
                )
            )
        );
    }

    public function testAddFactory()
    {
        $container = new Container();
        $def       = $container->addFactory(
            'id',
            function () {
                return new \stdClass();
            }
        );
        $def       = $container->addFactory(
            'failed',
            function () {
                return "foo";
            }
        );

        $this->assertInstanceOf(FactoryDefinition::class, $def);
        $this->assertTrue($container->has('id'));

        // Should throw an exception
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessageRegExp('#returns no service instance#is');
        $container->get('failed');
    }

    public function testHasService()
    {
        $container = new Container();
        $container->addInstance('id', new \stdClass());

        $this->assertTrue($container->has('id'));
        $this->assertFalse($container->has('unknown'));
    }

    public function testUnknownService()
    {
        $this->expectException(NotFoundException::class);

        (new Container())->get('unknown');
    }

    public function testFaultyFactoryCallback()
    {
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessageRegExp('#Found "string"#is');

        $container = new Container();
        $container->addFactory(
            'id',
            function () {
                return 'foobar';
            }
        );
        $container->get('id');
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
