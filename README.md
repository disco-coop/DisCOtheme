# WordPress DisCOtheme

A Divi child theme for the [DisCO website](https://disco.coop/).

## Install dependencies

```shell
yarn install
```

## Development mode

```shell
yarn watch
```

## Production build

```shell
yarn build
```

## Upload to server

```shell
rsync -azPFc ./ ${SERVER}:${DOCUMENT_ROOT}/wp-content/themes/DisCOtheme/
```