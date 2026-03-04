# Changelog

## [0.1.1](https://github.com/sumup/sumup-php/compare/v0.1.0...v0.1.1) (2026-03-04)


### Features

* sync with latest openapi specs ([9509daf](https://github.com/sumup/sumup-php/commit/9509daf539d9f7af4a1422477b5b680726d7bc14))


### Miscellaneous Chores

* synced file(s) with sumup/apis ([#16](https://github.com/sumup/sumup-php/issues/16)) ([5564126](https://github.com/sumup/sumup-php/commit/55641263d74682c9f643acba15e8c3521dc724a8))

## [0.1.0](https://github.com/sumup/sumup-php/compare/v0.0.1...v0.1.0) (2026-02-23)


### ⚠ BREAKING CHANGES

* **api:** property access like $sumup->checkouts is no longer supported; use $sumup->checkouts() instead.

### Features

* **api:** remove magic service properties from SumUp ([18c35c4](https://github.com/sumup/sumup-php/commit/18c35c41ea646ef705aea3a07fd14340714cfc37))
* **api:** type core client interfaces and service access ([5f15c0a](https://github.com/sumup/sumup-php/commit/5f15c0a7b001f840e998fd1c1076694c8f7709cb))
* **cd:** auto-generate SDK ([442dfeb](https://github.com/sumup/sumup-php/commit/442dfeb20a9c81e155b62a5aa8438139d740db69))
* **codegen:** consolidate component models into Types namespace ([08a0b17](https://github.com/sumup/sumup-php/commit/08a0b17cdf0a9ee22a0ba274bf400887f6f13bc0))
* **codegen:** emit typed service signatures ([6c7356f](https://github.com/sumup/sumup-php/commit/6c7356fd82cc37e6fcc0e37959af7c16c0658dc2))
* **errors:** decode OpenAPI error bodies and throw typed API exceptions ([df49313](https://github.com/sumup/sumup-php/commit/df4931374e7292b481b3ecd4ba66e6f5cb32bbc9))
* **http:** expose response headers and raw body for diagnostics ([f1d668d](https://github.com/sumup/sumup-php/commit/f1d668dbeda32976d7b20e4e9844223c9f55f7a7))
* improve service request ergonomics ([e1a1624](https://github.com/sumup/sumup-php/commit/e1a16245011977196bcde792f28b5b625c7efdbc))
* **php-sdk:** add error envelope and raise static analysis to level 6 ([17fd86b](https://github.com/sumup/sumup-php/commit/17fd86b3340c2ab3ca6368eee9d89d0c2dd306fd))
* **php-sdk:** replace magic request option arrays with typed RequestOptions ([3aa9a89](https://github.com/sumup/sumup-php/commit/3aa9a89ff7f9b4ff9e036671cd70557d498658b3))
* provide guzzle client out of the box ([f8f70df](https://github.com/sumup/sumup-php/commit/f8f70dfcb249d818c1a7f0536bd5b78f538d6eef))
* type schema-less request bodies in codegen ([1faa9ef](https://github.com/sumup/sumup-php/commit/1faa9ef99aa23543e04667b65a7d79737875b1e5))


### Bug Fixes

* **cd:** generate workflow write permission ([6697c8e](https://github.com/sumup/sumup-php/commit/6697c8ed58c15ab5d9454510c685e0d0f130bbe1))
* **codegen:** lint issues ([d4da561](https://github.com/sumup/sumup-php/commit/d4da5616c1621842763b0994a705ce5a7ef327b6))
* **docs:** README badges ([35570c5](https://github.com/sumup/sumup-php/commit/35570c59bb1fda27d23e4eec56e0991c3be4b899))
* **docs:** README examples, checkout example ([06159ec](https://github.com/sumup/sumup-php/commit/06159ec8fb6eb1dc4561251b8ccd2afcfe878d14))
* **hydrator:** support backed enum casting during hydration ([a15ee8d](https://github.com/sumup/sumup-php/commit/a15ee8d58905bb7752411a515ebe690cccfa888e))
* resolve phpstan type/docblock violations ([6b471ec](https://github.com/sumup/sumup-php/commit/6b471eca48e7afa3fc489053be349ea6f7f6de13))


### Miscellaneous Chores

* **cd:** adjust generate workflow ([12b6107](https://github.com/sumup/sumup-php/commit/12b6107c6280f704dda56702f141c150b3747a84))
* harden phpstan checks and CI gating ([6355192](https://github.com/sumup/sumup-php/commit/6355192541002cd20727fce49292d1e70b75a719))
* raise phpstan strictness to level 5 ([14fb68d](https://github.com/sumup/sumup-php/commit/14fb68de426333fb59e775dd0d0b73fd37afa74c))
* regenerate code ([e41bde2](https://github.com/sumup/sumup-php/commit/e41bde2d657155d95ce14fe520c2173175e8e338))
* synced file(s) with sumup/apis ([#5](https://github.com/sumup/sumup-php/issues/5)) ([ca75c20](https://github.com/sumup/sumup-php/commit/ca75c207ef4874145278fa55ccec42973cb7433f))
* synced file(s) with sumup/apis ([#8](https://github.com/sumup/sumup-php/issues/8)) ([3891105](https://github.com/sumup/sumup-php/commit/38911057e1ec3de920134894bc7c947d483c8a50))

## 0.0.1 (2026-01-31)


### Features

* authorization simplification ([282d2f5](https://github.com/sumup/sumup-php/commit/282d2f55a767ae8a52ac2aab6f8173701730363a))
* cleanup, deterministic output ([eebd1a8](https://github.com/sumup/sumup-php/commit/eebd1a85627b56d686935ebc06bdc5f9c205243f))
* custom http clients support ([cd00e04](https://github.com/sumup/sumup-php/commit/cd00e04ce6c53f26c417fb68b74fbccdf2e276f1))
* improve query params handling ([0eff5a6](https://github.com/sumup/sumup-php/commit/0eff5a67421d6912a6393b930d963b9a273ae81d))
* improve response parsin ([a2432fe](https://github.com/sumup/sumup-php/commit/a2432fe01190f83e647d4f88d792154c2c07870d))
* improve sdk typing ([1eb79bf](https://github.com/sumup/sumup-php/commit/1eb79bf4cfbfbb8bef93d6b56225024178b3bddb))
* init ([0a390f4](https://github.com/sumup/sumup-php/commit/0a390f43cb81cff0846bb938e94aad64a69a7840))
* oauth2 example ([3e1ff06](https://github.com/sumup/sumup-php/commit/3e1ff065dedd11f10b9f593ae64af1661b14c527))
* per-request options ([c0b8fe3](https://github.com/sumup/sumup-php/commit/c0b8fe3f8539386041ba5bdef5748cefe95eb7e2))
* phpdoc ([81964f1](https://github.com/sumup/sumup-php/commit/81964f174d230de11306e066c547a7816b3eaefd))
* release 0.0.1 ([386e628](https://github.com/sumup/sumup-php/commit/386e628846c3de0be75d9a5deba1666a3cab2b56))
* report runtime info ([#28](https://github.com/sumup/sumup-php/issues/28)) ([941c43e](https://github.com/sumup/sumup-php/commit/941c43e6e6f23c858cdfc6404285041a649d1f85))
* restructure ([3f98d9c](https://github.com/sumup/sumup-php/commit/3f98d9c6eae49e3c92c9259ebf042c2a8a55e9e3))
* support enums ([e443679](https://github.com/sumup/sumup-php/commit/e4436798aaa03b367828d8a286ff976245399859))


### Bug Fixes

* better schema generation ([cf0375b](https://github.com/sumup/sumup-php/commit/cf0375b35441bc0585a07a0da1e4c64c64885cfd))
* **codegen:** run make fmt ([8fac107](https://github.com/sumup/sumup-php/commit/8fac107775d50aaf939a1b86570f8db674391240))
* **docs:** README refs ([bbdd374](https://github.com/sumup/sumup-php/commit/bbdd374835f75137887def92ff329bd80722faf4))
* github actions ([135efbb](https://github.com/sumup/sumup-php/commit/135efbb94fb0187db48d304993db12cfef139729))
* response bodies for non-ref schemas ([056a961](https://github.com/sumup/sumup-php/commit/056a961f066431afd2b5cff1136ca747bd417d96))


### Miscellaneous Chores

* adjust release please config ([f57869c](https://github.com/sumup/sumup-php/commit/f57869c27329712945e79a6c6f1ee53b37ef6a73))
* bump deps for codegen ([dca9b76](https://github.com/sumup/sumup-php/commit/dca9b760ed12cd68705fdf0b5f5d147efd419337))
* cleanup and fix codegen ([614fe34](https://github.com/sumup/sumup-php/commit/614fe34b9d56fb2475f2d4fb972242d25035cc2f))
* cleanup auth ([47f621e](https://github.com/sumup/sumup-php/commit/47f621e9165e276cb7a6eaa8d364640face5e62f))
* cleanup password grant ([c164b70](https://github.com/sumup/sumup-php/commit/c164b70bf28a8264f116c18c80561a0ae71eb9d2))
* **codegen:** bump all deps ([366b14b](https://github.com/sumup/sumup-php/commit/366b14bca5b98ea36e753f84a4c75b1a8d12072a))
* docs updates ([04b563d](https://github.com/sumup/sumup-php/commit/04b563da4e5c3654209b713dfb42e8c34d614794))
* further refactoring ([244c192](https://github.com/sumup/sumup-php/commit/244c19248443d3257db5a2e1a92d316735266757))
* further simplification ([23819ed](https://github.com/sumup/sumup-php/commit/23819ed3801e31df929c306825b9b3f9ae0c9256))
* major refactor and cleanup ([aa48bd2](https://github.com/sumup/sumup-php/commit/aa48bd20f9aca71376dd9f9b73b81c537445f71b))
* more cleanup and fixups ([358e86e](https://github.com/sumup/sumup-php/commit/358e86e650b02ff641c6e5f1e9a6978e073e44ad))
* prepare for public ([0b2b926](https://github.com/sumup/sumup-php/commit/0b2b92657aeae221ecd6ad34e5185179c7097458))
* remove form encoding header ([0db9a49](https://github.com/sumup/sumup-php/commit/0db9a49e0c5b11a5430a1c74a1228a3dd32be41f))
* remove openapi.yaml ([8604895](https://github.com/sumup/sumup-php/commit/8604895945553a9d5b44e0f9d4d8ff3accbcde48))
* **sdk:** cleanup exceptions ([c5467f5](https://github.com/sumup/sumup-php/commit/c5467f5baf9a0138aef135b2b3de240281f5cc6d))
* simplify configuration ([189e937](https://github.com/sumup/sumup-php/commit/189e937bff4fa4adfaa75ec52ec481397889e339))
* simplify setup of services ([342341a](https://github.com/sumup/sumup-php/commit/342341ad60654bf09335f5f891bd25e2380cac6c))
