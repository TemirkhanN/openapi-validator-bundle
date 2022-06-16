
IMAGE_NAME=temirkhann/php7.4
CLI=docker run --rm -v ${PWD}:/app -it $IMAGE_NAME


.PHONY: image
image:
    docker build . -t ${IMAGE_NAME}

.PHONY: test
test:
	make image
	$(CLI) composer init