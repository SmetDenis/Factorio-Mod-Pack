.PHONY: build
.DEFAULT_GOAL := build

build:
	@echo "\033[0;33m>>> >>> >>> >>> >>> >>> >>> >>> \033[0;30;46m Build package \033[0m"
	@rm    -fr ./build
	@mkdir -p  ./build
	@cp -R ./ ./build
	@cd ./build; zip -r9q smetdenis-mod-pack.zip *
	@echo "ok"
