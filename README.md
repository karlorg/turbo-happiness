Quick reference for various things I might want to do with a web server.

I left the compiled output in `out/` in case you just want to try this without compiling.

## Compile

	haxe build.hxml

## Run neko

	cd out
	nekotools server -rewrite

(`-rewrite` enables rewriting, eg., `localhost:2000/cool` to `localhost:2000/index.n/cool`)

## Run PHP

	cd out
	php -S localhost:2001

## Operation

Browse to `localhost:2000` (neko) or `localhost:2001` (PHP).  Access `/get` to see the contents of the database, `/insert?name=XXX&age=XXX` to add a new record.
