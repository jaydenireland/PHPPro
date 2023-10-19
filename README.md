# PHPPro

An application for testing PHP code inspired by [RunJS](https://runjs.app/).

![Screenshot](https://user-images.githubusercontent.com/719397/276780214-ca05896c-d532-4ff0-893a-d263741a6807.png)
## Things to note
1. Uses [@php-wasm/node](https://www.npmjs.com/package/@php-wasm/node) for php evaluation. Locked to version 8.0.10 for now.
2. Any statement that doesn't output will be wrapped in a var_dump.

## Recommended IDE Setup

- [VSCode](https://code.visualstudio.com/) + [ESLint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint) + [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) + [TypeScript Vue Plugin (Volar)](https://marketplace.visualstudio.com/items?itemName=Vue.vscode-typescript-vue-plugin)

## Project Setup

### Install

```bash
$ npm install
```

### Development

```bash
$ npm run dev
```

### Build

```bash

# For macOS
$ npm run build:mac

```
