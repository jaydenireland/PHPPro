<?php
namespace PhpProParser\Parser;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter\Standard;

class Output {

    /**
     * Wrap statements with var_dump
     */
    public static function wrapAstWithVarDump(array $ast): array {
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class extends NodeVisitorAbstract {
            public function leaveNode(Node $node) {
                // If the node is an Expression (usually a top-level statement in PHP) but isn't an assignment or an already-wrapped var_dump
                if ($node instanceof Expression && !($node->expr instanceof Assign) && !($node->expr instanceof FuncCall && $node->expr->name->toString() === 'var_dump')) {
                    $prettyPrinter = new Standard();
                    $codeString = $prettyPrinter->prettyPrint([$node->expr]);

                    return [
                        new Echo_([new String_("\n\n*" . $codeString . "*\n\n")]),
                        new Expression(new FuncCall(new Name('var_export'), [$node->expr])),
                        new Echo_([new String_("<br /> <br />")]),
                    ];
                }
            }
        });

        return $traverser->traverse($ast);
    }
}
