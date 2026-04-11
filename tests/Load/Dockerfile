FROM golang:1.24-alpine AS builder

WORKDIR /app

ENV CGO_ENABLED=0

RUN apk add --no-cache git

RUN go install go.k6.io/xk6/cmd/xk6@v0.11.0

RUN xk6 build \
    --with github.com/grafana/xk6-dashboard@v0.8.1 \
    --with github.com/mstoykov/xk6-counter@v0.0.1  \
    --with github.com/grafana/xk6-exec@v0.3.0

FROM alpine

COPY --from=builder /app/k6 /bin/

ENTRYPOINT [ "k6" ]
