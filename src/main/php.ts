import { NodePHP } from '@php-wasm/node'
import { app } from 'electron'
import path from 'path'

export const run = async (code: string) => {
  return new Promise(async (resolve, reject) => {
    const php = await NodePHP.load('8.0')

    const phpSource = path.join(app.getAppPath(), 'resources', 'php').replace('app.asar', 'app.asar.unpacked')
    php.mount(phpSource, '/home/runner')

    const res = await php.run({
      code: `<?php
            require '/home/runner/vendor/autoload.php';

            use PhpProParser\\Runner\\Runner;


            try {
                $runner = new Runner();
                $input = <<<'EOD'
${code}
EOD;
                $code = $runner->format($input);
            } catch (\Exception $error) {
                echo $error->getMessage();
                exit();
            }

            try {
                eval($code);
            } catch (\\ParseError $error) {
                echo $error->getMessage();
            }
            `
          })
    // timeout after 10 seconds
    setTimeout(() => reject('timeout'), 10000)
    const text = new TextDecoder('utf-8').decode(res.bytes)
    resolve(text)
  })
}
