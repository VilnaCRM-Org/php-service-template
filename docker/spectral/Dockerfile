FROM stoplight/spectral:6.15.1

RUN addgroup -S spectral \
    && adduser -S -G spectral spectral \
    && mkdir -p /workspace \
    && chown -R spectral:spectral /workspace

WORKDIR /workspace

USER spectral

ENTRYPOINT ["spectral"]
CMD ["--help"]
