.PHONY: build
.DEFAULT_GOAL := build

MOD_VERSION ?= 0.1.1
MOD_PATH    ?= "/Users/smetdenis/Library/Application Support/factorio/mods/smetdenis-mod-pack_$(MOD_VERSION)"

build:
	@echo "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Build package \033[0m"
	@rm    -fr ./build
	@mkdir -p  ./build
	@rsync -av `pwd` `pwd`/build \
        --exclude build          \
        --exclude .git           \
        --exclude .idea
	@mv `pwd`/build/Factorio-Mod-Pack `pwd`/build/smetdenis-mod-pack
	@cd ./build; zip -r9q smetdenis-mod-pack.zip *
	@mv `pwd`/build/smetdenis-mod-pack.zip `pwd`/smetdenis-mod-pack.zip
	@echo "ok"


install:
	@echo "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Build package \033[0m"
	@make build
	@rm -fr $(MOD_PATH)
	@cp -r ./build/smetdenis-mod-pack $(MOD_PATH)
	@echo "Start the game"
