<?php

namespace Tests\ExampleTests;

use PHPUnit\Framework\TestCase;

class TestThatHasAllStatusesTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->assertTrue(true);
    }

    public function testFail(): void
    {
        $this->assertTrue(false);
    }

    public function testError(): void
    {
        throw new \Exception('error');
    }

    public function testRisky(): void
    {
    }

    public function testSkip(): void
    {
        $this->markTestSkipped('skipped');
    }

    public function testIncomplete(): void
    {
        $this->markTestIncomplete('incomplete');
    }

    public function testShouldConvertTitleCaseToLowerCasedWords(): void
    {
        $this->assertTrue(true);
    }

    public function testShouldConvertSnakeCaseToLowerCasedWords(): void
    {
        $this->assertTrue(true);
    }

    public function testCanContain1Or99Numbers(): void
    {
        $this->assertTrue(true);
    }

    public function test123CanStartOrEndWithNumbers456(): void
    {
        $this->assertTrue(true);
    }

    public function testShouldPreserveCAPITALIZEDAndPaRTiaLLYCAPitaLIZedWords(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @dataProvider provideData
     */
    public function testWithNamedDatasets(string $value): void
    {
        $this->assertEquals('test', $value);
    }

    public static function provideData(): array
    {
        return [
            'dataset1' => ['test'],
            'DataSet2' => ['test'],
            'data set 3' => ['test'],
        ];
    }
}
