.PHONY: setup up down check smoke theme-smoke import-plugins prepare-theme activate package wp

setup:
	./scripts/dev.sh setup
up:
	./scripts/dev.sh start
down:
	./scripts/dev.sh stop
check:
	python3 scripts/themes.py check
	./scripts/dev.sh lint
smoke:
	./scripts/dev.sh smoke
theme-smoke:
	./scripts/dev.sh theme-smoke
prepare-theme:
	./scripts/dev.sh prepare-theme
import-plugins:
	python3 scripts/import-plugins.py
activate:
	./scripts/dev.sh activate
package:
	python3 scripts/themes.py package
wp:
	./scripts/dev.sh wp $(ARGS)
