<?php
namespace PhpProParser\Runner;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PhpProParser\Parser\Output;

class Runner {
    public function format(string $code) {
        // Get the AST from the code
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse("<?php\n" . $code . "\n ?>");

        $ast = Output::wrapAstWithVarDump($ast);

        $prettyPrinter = new Standard();
        return $prettyPrinter->prettyPrint($ast);
    }
}
