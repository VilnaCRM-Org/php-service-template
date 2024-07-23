FROM golang:1.22-alpine AS builder

WORKDIR /app

ENV CGO_ENABLED=0
RUN go install go.k6.io/xk6/cmd/xk6@v0.11.0

RUN xk6 build \
    --with github.com/szkiba/xk6-faker@v0.3.0  \
    --with github.com/mstoykov/xk6-counter@v0.0.1  \
    --with github.com/grafana/xk6-exec@v0.3.0  \
    --with github.com/avitalique/xk6-file@v1.4.0

FROM alpine

COPY --from=builder /app/k6 /bin/

ENTRYPOINT [ "k6" ]
