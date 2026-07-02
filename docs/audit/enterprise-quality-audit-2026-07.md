# Enterprise Quality Audit — php-service-template

Date: 2026-07-02. Scope: every system quality attribute from the
[Wikipedia list of system quality attributes](https://en.wikipedia.org/wiki/List_of_system_quality_attributes),
plus AI-native autonomous-development readiness, scored 1–5 against an enterprise bar
(5 = fully enterprise-grade, automated/enforced in CI, documented — nothing meaningful left to add).

**Result: 94 attributes scored — average 3.48/5. No attribute reached 5/5** (56×4, 28×3, 9×2, 1×1). The gaps cluster into 28 root-cause problems, each tracked by a dedicated GitHub issue (#176–#203, see the "Remediation plan" section).

## Scorecard summary

### Security & Trust — avg 3.12

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| accountability | 3/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)), P3 ([#179](https://github.com/VilnaCRM-Org/php-service-template/issues/179)), P12 ([#186](https://github.com/VilnaCRM-Org/php-service-template/issues/186)) |
| auditability | 3/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)) |
| confidentiality | 2/5 | P3 ([#179](https://github.com/VilnaCRM-Org/php-service-template/issues/179)), P4 ([#178](https://github.com/VilnaCRM-Org/php-service-template/issues/178)) |
| credibility | 4/5 | P6 ([#180](https://github.com/VilnaCRM-Org/php-service-template/issues/180)), P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)), P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)) |
| integrity | 4/5 | P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)), P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| safety | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P5 ([#181](https://github.com/VilnaCRM-Org/php-service-template/issues/181)), P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| securability | 3/5 | P3 ([#179](https://github.com/VilnaCRM-Org/php-service-template/issues/179)), P5 ([#181](https://github.com/VilnaCRM-Org/php-service-template/issues/181)), P6 ([#180](https://github.com/VilnaCRM-Org/php-service-template/issues/180)) |
| vulnerability | 3/5 | P4 ([#178](https://github.com/VilnaCRM-Org/php-service-template/issues/178)), P6 ([#180](https://github.com/VilnaCRM-Org/php-service-template/issues/180)), P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)) |

### Reliability & Resilience — avg 2.69

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| availability | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| dependability | 4/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)), P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)) |
| degradability | 2/5 | P5 ([#181](https://github.com/VilnaCRM-Org/php-service-template/issues/181)), P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)) |
| durability | 2/5 | P14 ([#188](https://github.com/VilnaCRM-Org/php-service-template/issues/188)), P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| failure transparency | 3/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)), P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)) |
| fault-tolerance | 3/5 | P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)) |
| recoverability | 2/5 | P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)), P14 ([#188](https://github.com/VilnaCRM-Org/php-service-template/issues/188)) |
| redundancy | 1/5 | P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| reliability | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P14 ([#188](https://github.com/VilnaCRM-Org/php-service-template/issues/188)) |
| resilience | 2/5 | P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)) |
| robustness | 4/5 | P11 ([#187](https://github.com/VilnaCRM-Org/php-service-template/issues/187)), P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)), P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| stability | 4/5 | P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)) |
| survivability | 2/5 | P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)), P14 ([#188](https://github.com/VilnaCRM-Org/php-service-template/issues/188)), P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)) |

### Performance & Scalability — avg 3.29

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| efficiency | 4/5 | P17 ([#192](https://github.com/VilnaCRM-Org/php-service-template/issues/192)), P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)) |
| elasticity | 2/5 | P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| responsiveness | 4/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)), P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)) |
| scalability | 3/5 | P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)), P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)) |
| timeliness | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P17 ([#192](https://github.com/VilnaCRM-Org/php-service-template/issues/192)), P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)), P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)) |
| distributability | 3/5 | P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| precision | 4/5 | P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)) |

### Maintainability & Architecture — avg 3.89

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| adaptability | 4/5 | P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)), P27 ([#203](https://github.com/VilnaCRM-Org/php-service-template/issues/203)) |
| agility | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P17 ([#192](https://github.com/VilnaCRM-Org/php-service-template/issues/192)) |
| analyzability | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P11 ([#187](https://github.com/VilnaCRM-Org/php-service-template/issues/187)) |
| composability | 4/5 | P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| configurability | 4/5 | P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| customizability | 3/5 | P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)) |
| evolvability | 4/5 | P20 ([#194](https://github.com/VilnaCRM-Org/php-service-template/issues/194)), P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)), P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)) |
| extensibility | 4/5 | P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)) |
| flexibility | 4/5 | P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| interchangeability | 4/5 | P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| maintainability | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)) |
| modifiability | 4/5 | P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)) |
| modularity | 4/5 | P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| orthogonality | 4/5 | P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| reusability | 4/5 | P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)) |
| simplicity | 4/5 | P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)) |
| tailorability | 3/5 | P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)), P27 ([#203](https://github.com/VilnaCRM-Org/php-service-template/issues/203)) |
| understandability | 4/5 | P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |

### Testability & Correctness — avg 4.00

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| accuracy | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)), P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)) |
| correctness | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)) |
| demonstrability | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)) |
| determinability | 4/5 | P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)) |
| effectiveness | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)) |
| fidelity | 4/5 | P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)) |
| predictability | 4/5 | P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)) |
| provability | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)) |
| relevance | 4/5 | P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)), P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)) |
| repeatability | 4/5 | P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)) |
| reproducibility | 4/5 | P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)) |
| testability | 4/5 | P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)) |

### Observability & Operability — avg 3.10

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| administrability | 3/5 | P4 ([#178](https://github.com/VilnaCRM-Org/php-service-template/issues/178)), P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)) |
| debuggability | 3/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)), P25 ([#200](https://github.com/VilnaCRM-Org/php-service-template/issues/200)) |
| inspectability | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P25 ([#200](https://github.com/VilnaCRM-Org/php-service-template/issues/200)) |
| manageability | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)) |
| observability | 2/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)), P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)) |
| operability | 3/5 | P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)), P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| repairability | 3/5 | P14 ([#188](https://github.com/VilnaCRM-Org/php-service-template/issues/188)) |
| serviceability | 4/5 | P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)), P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)) |
| traceability | 3/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)) |
| transparency | 4/5 | P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)), P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)) |

### Deployability & Portability — avg 3.70

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| compatibility | 4/5 | P20 ([#194](https://github.com/VilnaCRM-Org/php-service-template/issues/194)), P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)) |
| deployability | 3/5 | P4 ([#178](https://github.com/VilnaCRM-Org/php-service-template/issues/178)), P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)) |
| installability | 4/5 | P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)) |
| interoperability | 4/5 | P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)) |
| mobility | 4/5 | P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)), P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)) |
| portability | 3/5 | P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)) |
| seamlessness | 4/5 | P12 ([#186](https://github.com/VilnaCRM-Org/php-service-template/issues/186)) |
| standards compliance | 4/5 | P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)), P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)) |
| ubiquity | 3/5 | P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)) |
| upgradability | 4/5 | P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)), P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)) |

### Usability & Developer Experience — avg 3.56

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| accessibility | 3/5 | P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)), P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| convenience | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)), P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| discoverability | 4/5 | P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)), P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| familiarity | 4/5 | P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| interactivity | 3/5 | P25 ([#200](https://github.com/VilnaCRM-Org/php-service-template/issues/200)) |
| intuitiveness | 4/5 | P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)), P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)) |
| learnability | 4/5 | P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)) |
| localizability | 2/5 | P20 ([#194](https://github.com/VilnaCRM-Org/php-service-template/issues/194)) |
| usability | 4/5 | P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)), P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)), P25 ([#200](https://github.com/VilnaCRM-Org/php-service-template/issues/200)) |

### Process, Sustainability & AI-Native — avg 3.71

| Attribute | Score | Remediation issue(s) |
|---|---|---|
| affordability | 3/5 | P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)), P17 ([#192](https://github.com/VilnaCRM-Org/php-service-template/issues/192)) |
| autonomy | 4/5 | P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)) |
| process capabilities | 4/5 | P12 ([#186](https://github.com/VilnaCRM-Org/php-service-template/issues/186)), P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)) |
| producibility | 3/5 | P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)), P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)) |
| self-sustainability | 4/5 | P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)) |
| sustainability | 4/5 | P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)), P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)), P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)), P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)), P27 ([#203](https://github.com/VilnaCRM-Org/php-service-template/issues/203)) |
| ai-native-readiness | 4/5 | P27 ([#203](https://github.com/VilnaCRM-Org/php-service-template/issues/203)) |

## Remediation plan (root-cause problems)

Each problem below is filed as a GitHub issue. Closing all 28 brings every attribute above to 5/5.

### P1 ([#176](https://github.com/VilnaCRM-Org/php-service-template/issues/176)): Add structured application logging and audit trail (monolog, correlation IDs)

*Unblocks:* accountability, auditability, debuggability, dependability, failure transparency, observability, traceability, transparency

The template ships no application logging at all: symfony/monolog-bundle is absent from composer.json, there is no config/packages/monolog.yaml, no JSON log formatting, no request/correlation ID propagation, and no persistence of domain events from src/Shared/Domain/Bus/Event as an audit trail.

- Install symfony/monolog-bundle with JSON formatter to stderr
- Request/correlation-ID processor so every log line is correlatable (symfony/uid)
- Audit-log channel example and optional domain-event audit table + Doctrine migration
- Log retention/shipping guidance (CloudWatch via existing LocalStack) in docs

### P2 ([#177](https://github.com/VilnaCRM-Org/php-service-template/issues/177)): Add observability baseline: OpenTelemetry tracing, metrics, error tracking, SLOs and per-dependency health payload

*Unblocks:* availability, failure transparency, inspectability, manageability, observability, operability, reliability, responsiveness, safety, timeliness

No OpenTelemetry, no metrics endpoint (Prometheus/OTLP), no error-tracking integration (e.g. Sentry) even as a commented option, no SLO/alerting scaffold, and the /api/health endpoint returns a bare 204/500 with no per-dependency status body for load-balancer routing or diagnosis.

- OpenTelemetry SDK with OTLP exporter wired via env vars
- Metrics endpoint or OTLP metrics export with example dashboards/alert rules
- Extend HealthCheck module to return per-dependency status payload (db/cache/broker)
- Optional commented Sentry (or similar) integration
- Document SLOs and alerting baseline in docs

### P3 ([#179](https://github.com/VilnaCRM-Org/php-service-template/issues/179)): Add authentication/authorization baseline with symfony/security-bundle

*Unblocks:* accountability, confidentiality, securability

There is no authn/authz at all: symfony/security-bundle is not installed, config/packages/security.yaml does not exist, and no firewall/voter/IsGranted usage exists in src/, so every downstream service starts with an anonymous, unprotected API.

- Install symfony/security-bundle with a stateless firewall template (config/packages/security.yaml)
- access_control examples for API Platform endpoints and a commented JWT/OAuth2 option
- Keep Domain layer framework-free per the agent contract
- Behat scenario proving a protected endpoint returns 401 without credentials

### P4 ([#178](https://github.com/VilnaCRM-Org/php-service-template/issues/178)): Secrets management: remove committed secrets, add generation script, vault/Secrets Manager wiring and secrets scanning in CI

*Unblocks:* administrability, confidentiality, deployability, vulnerability

The committed .env contains a real-looking APP_SECRET=2e222659c5b006df8d0e68cc33913706 and default Mercure JWT placeholder secrets; there is no secrets-manager integration or guidance (despite LocalStack being present) and no secrets scanning (gitleaks/trufflehog) in CI.

- Replace committed secrets with obvious CHANGE_ME placeholders and a script to generate APP_SECRET
- Document/wire AWS Secrets Manager or Symfony secrets vault against existing LocalStack
- Add gitleaks (or equivalent) secrets-scanning workflow
- Document each .env variable's purpose inline

### P5 ([#181](https://github.com/VilnaCRM-Org/php-service-template/issues/181)): API hardening: rate limiting, security headers and safe Mercure defaults

*Unblocks:* degradability, safety, securability

symfony/rate-limiter is not installed and no limiter config exists; the Caddyfile sets no security headers (HSTS, CSP, X-Frame-Options, X-Content-Type-Options); and infrastructure/docker/caddy/Caddyfile enables anonymous Mercure subscriptions by default.

- Add symfony/rate-limiter with default policy wired to API Platform endpoints
- Add security headers in Caddyfile with documented rationale
- Remove/guard the anonymous Mercure directive default
- Behat/integration coverage for 429 responses and headers

### P6 ([#180](https://github.com/VilnaCRM-Org/php-service-template/issues/180)): Supply-chain and container security scanning: Trivy image scan, extended SAST, OSSF Scorecard, container runtime hardening

*Unblocks:* credibility, securability, vulnerability

No container image scanning (Trivy/Grype) for the FrankenPHP image, SAST is limited to Psalm taint SARIF upload, no OpenSSF Scorecard workflow/badge, and container hardening stops at non-root (no read_only rootfs, cap_drop, security_opt no-new-privileges in docker-compose.prod.yml).

- Trivy (or Grype) image + filesystem scan workflow failing on HIGH/CRITICAL
- ossf/scorecard-action workflow with README badge
- read_only rootfs, cap_drop: [ALL], no-new-privileges and tmpfs in docker-compose.prod.yml
- Keep existing Psalm taint SARIF; add composer audit gate if missing

### P7 ([#182](https://github.com/VilnaCRM-Org/php-service-template/issues/182)): Release engineering: publish versioned container image to GHCR with SBOM, cosign signing and SLSA provenance

*Unblocks:* credibility, deployability, integrity, interoperability, manageability, portability, producibility, transparency, ubiquity

autorelease.yml only tags and writes release notes: no workflow builds/publishes the frankenphp_prod image to any registry, and there is no SBOM, image signing (cosign) or SLSA provenance attestation, so releases produce no verifiable deployable artifact and there is no CD path.

- Release workflow building frankenphp_prod with buildx and pushing to GHCR tagged with the release version
- SBOM generation (anchore/sbom-action or syft)
- cosign signing + actions/attest-build-provenance SLSA provenance
- Document image consumption/rollback by tag in docs

### P8 ([#183](https://github.com/VilnaCRM-Org/php-service-template/issues/183)): Enforce mutation testing quality gate: add --min-msi/--min-covered-msi thresholds to Infection

*Unblocks:* accuracy, agility, analyzability, convenience, correctness, demonstrability, dependability, effectiveness, maintainability, provability, reliability, sustainability

Infection runs in CI (infection.yml) and locally (make infection) but neither infection.json5 nor the Makefile sets --min-msi/--min-covered-msi, so the mutation-testing job passes regardless of mutation score - the gate exists but has no threshold.

- Set minMsi/minCoveredMsi in infection.json5 (or Makefile flags) at current baseline level
- Fail CI below threshold; document ratchet-up policy
- Align with the 'do not lower quality gates' contract in CLAUDE.md

### P9 ([#185](https://github.com/VilnaCRM-Org/php-service-template/issues/185)): Enforce code coverage targets and deduplicate coverage CI jobs

*Unblocks:* accuracy, affordability, correctness, demonstrability, effectiveness, modifiability, provability, responsiveness, sustainability

phpunit.xml.dist has an empty <coverage> block with no thresholds, there is no codecov.yml with project/patch targets (coverage can silently regress; only the upload is guarded), and tests.yml plus codecov.yml both run the full PHPUnit coverage suite and upload to Codecov, duplicating cost.

- codecov.yml with project and patch targets
- Optional phpunit --coverage + threshold check in CI
- Merge tests.yml and codecov.yml into a single coverage job

### P10 ([#184](https://github.com/VilnaCRM-Org/php-service-template/issues/184)): Deterministic and strict test suite: seeded Faker, random execution order, PHPUnit strictness flags, replace placeholder demo.feature

*Unblocks:* accuracy, determinability, predictability, relevance, repeatability, reproducibility, testability

tests/Unit/UnitTestCase.php creates Faker via Factory::create() without a seed so runs are not reproducible; phpunit.xml.dist has no executionOrder=random, failOnRisky or beStrictAboutOutputDuringTests; features/demo.feature only asserts 'the response should be received' (placeholder-level); and there is no documented flaky-test/seed-capture policy.

- Seed Faker from env var with seed printed on failure for replay
- executionOrder=random + defects ordering, failOnRisky, beStrictAboutOutputDuringTests in phpunit.xml.dist
- Replace features/demo.feature with a real behavioral scenario
- Document flaky-test policy in CONTRIBUTING.md

### P11 ([#187](https://github.com/VilnaCRM-Org/php-service-template/issues/187)): Raise Psalm errorLevel from 8 toward strict static analysis

*Unblocks:* analyzability, robustness

psalm.xml sets errorLevel=8 - the most permissive level - so most type-level defects are invisible despite Psalm running in CI; this contradicts the otherwise strict gate posture (PHPInsights 100/95/100/100).

- Ratchet errorLevel stepwise (8 -> 4 -> 2/1) fixing findings at each step
- Enable stricter flags (e.g. findUnusedCode) where feasible
- Update the locked-config policy notes so the ratchet is one-way

### P12 ([#186](https://github.com/VilnaCRM-Org/php-service-template/issues/186)): Engineering governance as code: CODEOWNERS, branch-protection rulesets, pre-push hook, fix bot-push conflict

*Unblocks:* accountability, process capabilities, seamlessness

No CODEOWNERS file exists; branch protection/required status checks are not captured as code or documented; the pre-push hook is disabled in captainhook.json; .github/linters/ is an empty directory; and code-lint-and-prettify.yml pushes directly to main (push origin HEAD:main), which conflicts with any branch-protection model.

- .github/CODEOWNERS mapping src/, config/, .github/workflows/ to maintainers
- Repository rulesets exported as code or required checks documented in CONTRIBUTING.md
- Enable pre-push hook; remove or populate .github/linters/
- Rework auto-fix bot to open PRs instead of pushing to main

### P13 ([#189](https://github.com/VilnaCRM-Org/php-service-template/issues/189)): Complete SECURITY.md: supported versions, disclosure SLA, scope, remove TBD

*Unblocks:* credibility, discoverability, process capabilities, recoverability, survivability, usability, vulnerability

SECURITY.md is a 6-line stub whose Known vulnerabilities section literally says 'TBD', with no supported-versions table, no response SLA, no scope, and no security-incident contact path - weak trust signal for an enterprise template.

- Supported versions table and disclosure SLA
- Scope (template vs downstream services) and hardening pointers
- Replace TBD with a real known-vulnerabilities process (GH advisories)

### P14 ([#188](https://github.com/VilnaCRM-Org/php-service-template/issues/188)): Backup, disaster-recovery and rollback runbooks (RPO/RTO, migration rollback, image rollback)

*Unblocks:* durability, recoverability, reliability, repairability, survivability

There is no backup/restore guidance for Postgres volumes, no DR plan or RPO/RTO discussion, no documented/tested Doctrine migrations down-path, and no image-version rollback procedure - recovery is entirely undefined for template adopters.

- docs/runbooks: backup/restore for Postgres (pg_dump/WAL), RPO/RTO guidance
- Tested migration rollback procedure + make target
- Image rollback guidance tied to versioned GHCR tags
- Restore-verification step (scheduled or documented drill)

### P15 ([#191](https://github.com/VilnaCRM-Org/php-service-template/issues/191)): High-availability and scaling reference: multi-instance topology, resource limits, restart policies, Mercure SPOF, autoscaling guidance

*Unblocks:* availability, distributability, durability, elasticity, manageability, mobility, redundancy, safety, scalability

docker-compose.prod.yml runs a single PHP node and single Postgres with no resource limits (cpus/memory) or restart policies, Mercure uses node-local bolt:///data/mercure.db storage (single point of failure), and there is no documented multi-instance/load-balanced topology, autoscaling or orchestrator (K8s/ECS) reference despite infrastructure/ existing.

- Resource limits + restart: unless-stopped in docker-compose.prod.yml
- Documented multi-replica topology and statelessness requirements (sessions, Mercure transport)
- Reference manifests or guidance for K8s/ECS in infrastructure/
- Single-points-of-failure documentation for adopters

### P16 ([#190](https://github.com/VilnaCRM-Org/php-service-template/issues/190)): Resilience patterns: retries/timeouts/circuit breakers, transactional outbox and idempotency examples, chaos/recovery tests, soak+stress in CI, kill switches

*Unblocks:* administrability, degradability, fault-tolerance, resilience, robustness, stability, survivability

Messenger retry/backoff and HTTP client timeout patterns are not demonstrated, there are no transactional-outbox or idempotency examples for the CQRS buses, no test kills Postgres/LocalStack mid-traffic to prove recovery, k6 spike/stress scenarios exist but never run in CI, there is no soak/endurance profile to catch leaks, and no feature-flag/kill-switch mechanism exists.

- Messenger retry_strategy + failure transport example config
- Transactional outbox + idempotency-key exemplar in the sample module
- Chaos/recovery integration test (dependency restart mid-traffic)
- Scheduled CI job running stress/spike + a soak profile
- Feature-flag/kill-switch baseline (env-driven)

### P17 ([#192](https://github.com/VilnaCRM-Org/php-service-template/issues/192)): CI cost and speed: shared image build with layer caching, concurrency cancellation, paths filters, remove duplicate jobs

*Unblocks:* affordability, agility, efficiency, timeliness

~15 PR workflows each rebuild the FrankenPHP Docker image from scratch via make start (the only cache anywhere is pnpm in eslint.yaml), no workflow has a concurrency cancellation group, only eslint.yaml has paths filters (docs-only PRs still run Infection, K6, Schemathesis), and coverage runs twice (tests.yml + codecov.yml).

- Shared build job with docker/build-push-action cache-from/to type=gha (or prebuilt CI image in GHCR) reused by downstream jobs
- concurrency: group + cancel-in-progress on all PR workflows
- paths filters or changed-files gate for heavy jobs (infection, load-tests, schemathesis)
- Merge duplicate coverage jobs

### P18 ([#193](https://github.com/VilnaCRM-Org/php-service-template/issues/193)): Autonomous repo maintenance: scheduled CI on main, Dependabot for github-actions and docker, auto-merge for green dependency PRs, stale bot, workflow tests

*Unblocks:* autonomy, relevance, self-sustainability, sustainability, timeliness, upgradability

All quality workflows are pull_request-only so main cannot detect bit-rot or new dependency CVEs between PRs; dependabot.yml covers only composer and npm (not github-actions or docker); automated PRs cannot land without the single hardcoded reviewer (no auto-merge); there is no stale issue/PR automation; and the template-sync/autorelease workflows themselves have no tests.

- Weekly cron workflow running make ci + make check-security on main with failure notifications
- Extend dependabot.yml with github-actions and docker ecosystems
- Auto-merge workflow for green grouped Dependabot PRs
- actions/stale; add bats tests for sync/release scripts

### P19 ([#195](https://github.com/VilnaCRM-Org/php-service-template/issues/195)): Performance budgets and regression tracking: tighten k6 thresholds, store baselines, publish trend artifacts

*Unblocks:* efficiency, fidelity, precision, responsiveness, scalability, timeliness

The only CI-enforced budget is the smoke profile p(99)<9000ms - far too lax to catch real latency regressions; results come from single runs on shared runners with no warm-up discard or repetition; k6 HTML dashboards in tests/Load/results/ are not uploaded as CI artifacts; and there are no stored baselines or run-over-run comparison, plus no DB indexing/connection-pooling guidance for scale.

- Realistic per-endpoint p95/p99 budgets in k6 thresholds
- Upload k6 dashboards/summaries as CI artifacts with retention
- Baseline storage + regression comparison step
- Document DB indexing and pooling conventions
- Address measurement fidelity: repeated runs/warm-up discard on shared runners so numbers are trustworthy

### P20 ([#194](https://github.com/VilnaCRM-Org/php-service-template/issues/194)): Ship a working i18n example: translation catalogs, Accept-Language negotiation, localized RFC 7807 errors

*Unblocks:* compatibility, evolvability, localizability

translations/ is completely empty, no code uses TranslatorInterface, no Accept-Language locale negotiation is configured, translation providers exist only as commented stubs, and no Behat scenario demonstrates localized validation/error messages through the RFC 7807 pipeline.

- translations/validators.en.yaml + one non-English locale (e.g. uk)
- set_locale_from_accept_language: true and translatable constraint messages in the example resource
- Behat scenario asserting localized RFC 7807 detail
- Document translation-provider workflow

### P21 ([#196](https://github.com/VilnaCRM-Org/php-service-template/issues/196)): Development environment ubiquity: devcontainer/Codespaces, .editorconfig, Windows/WSL guidance, arm64 multi-platform builds

*Unblocks:* accessibility, convenience, installability, mobility, portability, ubiquity

No .devcontainer/ or Codespaces config, no .editorconfig, heavy bash/GNU-make dependence with no Windows/WSL guidance in README, bats git submodules require a manual init step, no host-prerequisite preflight check, and no docker buildx multi-platform (linux/amd64,linux/arm64) build - Apple Silicon/Graviton is untested.

- .devcontainer/devcontainer.json working with Codespaces
- .editorconfig; Windows/WSL section in README
- Fold submodule init + prerequisites preflight into make start/bootstrap
- buildx multi-platform build (amd64+arm64) in CI/release

### P22 ([#197](https://github.com/VilnaCRM-Org/php-service-template/issues/197)): In-repo architecture and onboarding docs: ARCHITECTURE.md, ADRs, troubleshooting, one-shot bootstrap, .env and make-target reference, CODE_OF_CONDUCT, backend issue templates

*Unblocks:* accessibility, configurability, convenience, discoverability, familiarity, intuitiveness, learnability, operability, serviceability, understandability, usability

The hexagonal/DDD layout is only implied by workspace.dsl and deptrac.yaml with no ARCHITECTURE.md or ADRs; troubleshooting docs live only on the external wiki so downstream clones lose them; first-run requires discovering make install + make setup-test-db across multiple files (no make bootstrap); several make targets are undocumented; CODE_OF_CONDUCT.md is external-only; and issue templates are frontend-oriented defaults (browser/smartphone fields).

- ARCHITECTURE.md mapping DDD layers to Symfony + deptrac rules; docs/adr/ with key decisions
- Vendor troubleshooting into docs/TROUBLESHOOTING.md
- make bootstrap one-shot target + copy-pasteable first-run README block
- Document all make targets and .env vars; add CODE_OF_CONDUCT.md; backend-appropriate issue templates

### P23 ([#198](https://github.com/VilnaCRM-Org/php-service-template/issues/198)): Template customization and scaffolding: bootstrap-a-new-service guide, module generator, fix hardcoded deptrac placeholders and composer package name typo

*Unblocks:* adaptability, customizability, evolvability, extensibility, intuitiveness, tailorability

There is no guide for renaming the CompanySubdomain/SomeModule placeholder when bootstrapping a real service; deptrac.yaml hardcodes placeholder namespaces in regexes while agents are forbidden to edit it; no scaffolding generates a new bounded context (Domain/Application/Infrastructure); composer.json still carries the template identity with a typo ('vilnacrm/php-serice-template'); and there is no per-service extension point like an optional Makefile.local include.

- docs/NEW-SERVICE.md rename/bootstrap walkthrough (deptrac.yaml, workspace.dsl, composer.json)
- Scaffolding script/maker for a new module with all three layers
- Parameterize deptrac namespace patterns or document the sanctioned edit path
- Fix composer name typo; optional Makefile.local include

### P24 ([#199](https://github.com/VilnaCRM-Org/php-service-template/issues/199)): Contract and compatibility enforcement: fail openapi-diff on breaking changes, PHP version matrix, wire or remove phpcs, API versioning/deprecation policy, UPGRADE.md

*Unblocks:* compatibility, evolvability, interoperability, serviceability, standards compliance, upgradability

scripts/openapi-diff.sh invokes openapi-diff without --fail-on-incompatible so a breaking API change does not fail CI; composer.json declares php >=8.2 but CI only exercises 8.3 (no version matrix); phpcs.xml.dist (PSR-12) is dead config never run by any target or workflow; there is no documented API versioning/deprecation strategy (spec info.version static at 1.0.0); and no UPGRADE.md covers PHP/Symfony major upgrades or template-sync conflict resolution for downstream repos.

- Add --fail-on-incompatible to scripts/openapi-diff.sh (and equivalent for GraphQL diff)
- PHP 8.2/8.3(/8.4) matrix or tighten composer constraint
- Wire phpcs into CI or delete phpcs.xml.dist
- API versioning/deprecation policy + UPGRADE.md

### P25 ([#200](https://github.com/VilnaCRM-Org/php-service-template/issues/200)): Developer debugging tooling: web-profiler in dev, GraphiQL enabled for dev, ready-made .http/Postman collection

*Unblocks:* debuggability, inspectability, interactivity, usability

GraphiQL is explicitly disabled even for dev (config/packages/api_platform.yaml graphiql.enabled: false), symfony/web-profiler-bundle is not a dev dependency so there is no profiler/debug toolbar, and no HTTP client collection (.http/Postman) exists for exercising endpoints outside Swagger UI.

- Enable GraphiQL via when@dev override
- Add symfony/web-profiler-bundle (require-dev) with when@dev config
- Ship .http (or Postman) collection covering health-check + example resource

### P26 ([#201](https://github.com/VilnaCRM-Org/php-service-template/issues/201)): Repository hygiene: fix license mismatch, rename tempate-sync-pat.yml typo, SHA-pin remaining actions, digest-pin base images

*Unblocks:* credibility, integrity, producibility, simplicity, standards compliance, sustainability

composer.json declares license 'proprietary' while LICENSE and README say CC0-1.0; the workflow filename typo 'tempate-sync-pat.yml' propagates to downstream repos via sync; several workflows still use mutable action tags (actions/checkout@v4, crazy-max/ghaction-import-gpg@v6, AndreasAugustin/actions-template-sync@v2, github/codeql-action/upload-sarif@v3.25.4); and base images (dunglas/frankenphp:1-php8.3.17-alpine, postgres:*-alpine) are tag-pinned rather than digest-pinned.

- Align composer.json license with LICENSE (CC0-1.0)
- Rename tempate-sync-pat.yml -> template-sync-pat.yml
- SHA-pin remaining tag-pinned actions
- Digest-pin frankenphp and postgres base images
- Fix rector.php dev-mode hard failure (ContainerNotFoundException without warmed dev container XML)

### P27 ([#203](https://github.com/VilnaCRM-Org/php-service-template/issues/203)): AI-native hardening: run validate-configuration.sh in CI, docs-drift check for agent guides, .claude/settings.json allowlist and guardrail hooks

*Unblocks:* adaptability, ai-native-readiness, sustainability, tailorability

scripts/validate-configuration.sh (the lock on quality-gate configs) is only invoked from local make ci and no GitHub workflow runs it, so an agent that weakens gates and bypasses local hooks is not stopped by CI; nothing enforces that AGENTS.md/CLAUDE.md/.claude/skills command lists stay in sync with the Makefile; and there is no .claude/settings.json allowlisting safe make targets or hook blocking edits to locked config files.

- Required PR workflow step running scripts/validate-configuration.sh
- CI lint failing when make targets cited in AGENTS.md/CLAUDE.md/skills are missing from the Makefile
- .claude/settings.json with pre-approved safe commands + PreToolUse hook protecting locked quality configs
- Consider executable skill assets where docs-only skills fall short

### P28 ([#202](https://github.com/VilnaCRM-Org/php-service-template/issues/202)): Complete the CQRS/hexagonal exemplars: query bus, validated command DTO, repository port/adapter pair

*Unblocks:* composability, flexibility, integrity, interchangeability, modularity, orthogonality, reusability, robustness

CQRS is only half-modelled: there is a Command bus and Event bus but no Query bus/QueryHandlerInterface in src/Shared; the template ships no Symfony Validator constraint example (validator.yaml exists but no input-validation pattern to copy); and the sample module has no repository port (Domain interface) / adapter (Infrastructure implementation) pair demonstrating the hexagonal boundary.

- Query bus + QueryHandlerInterface in src/Shared mirroring the command side
- Exemplary command DTO with Validator constraints in the sample module
- Repository interface in Domain + Doctrine adapter in Infrastructure
- Unit/integration tests + deptrac compliance for the new exemplars
- Introduce a mailer port around the hard PHPMailer dependency so transports are swappable

## Detailed findings per attribute

### accessibility — 3/5

**Evidence:** Docs are plain portable Markdown (README.md, AGENTS.md, .claude/skills/*) explicitly designed to be tool-agnostic; `make help` is the default Makefile goal; entry is one command (`make start`) with only Docker as prerequisite. However there is no low-barrier remote entry (no .devcontainer/, no Codespaces config), no .editorconfig, no local CODE_OF_CONDUCT.md (CONTRIBUTING.md links to an external covenant), and .github/ISSUE_TEMPLATE/bug_report.md is the generic GitHub default asking for browser/smartphone details irrelevant to a backend API template.

**Gaps:**
- No .devcontainer/ or GitHub Codespaces setup for contributors who cannot run Docker locally
- No .editorconfig for cross-editor consistency
- No local CODE_OF_CONDUCT.md (only an external link in CONTRIBUTING.md)
- Issue templates are unmodified frontend-oriented defaults (browser/smartphone fields) that create friction for backend bug reports

**Recommendation:** Add a .devcontainer/devcontainer.json wired to docker-compose.yml so the template opens ready-to-run in Codespaces/VS Code; add .editorconfig and a local CODE_OF_CONDUCT.md; rewrite .github/ISSUE_TEMPLATE/bug_report.md (preferably as an issue form .yml) with backend-relevant fields (endpoint, request/response, logs, make target used).

### accountability — 3/5

**Evidence:** Change-level accountability is enforced: captainhook.json requires conventional commits referencing an issue number (regex feat|fix|...(#N):), .github/workflows/code-lint-and-prettify.yml GPG-signs bot commits, .github/dependabot.yml assigns a named reviewer, CONTRIBUTING.md defines a PR review flow with pull_request_template.md, and autorelease.yml produces attributable CHANGELOG releases via a GitHub App token.

**Gaps:**
- No CODEOWNERS file, so review responsibility per path is not enforced by GitHub
- No runtime actor attribution: no Symfony Security bundle (config/packages/security.yaml absent), so requests are anonymous by design
- No application audit logging (monolog is absent from composer.json and config/packages/)

**Recommendation:** Add .github/CODEOWNERS mapping src/, config/, .github/workflows/ to maintainers; add symfony/monolog-bundle with a config/packages/monolog.yaml channel for audit events; scaffold config/packages/security.yaml with a commented example firewall so downstream services attribute actions to authenticated principals.

### accuracy — 4/5

**Evidence:** Behavior is verified with precise, machine-checked assertions at several layers: features/health_check.feature asserts exact status codes (204/500) and exact error message bodies; .github/workflows/schemathesis.yml runs Schemathesis with '--checks all --phases=examples,coverage' against the exported OpenAPI spec (digest-pinned image in Makefile); scripts/openapi-diff.sh and graphql-diff.yml catch spec drift; tests/Load/utils/thresholdsBuilder.js enforces exact numeric SLOs (p(99)<threshold, checks rate>0.99).

**Gaps:**
- No enforced numeric accuracy floor for tests: phpunit.xml.dist has no coverage requirements and infection.json5/Makefile 'infection' target have no --min-msi, so inaccurate/weak assertions (surviving mutants) do not fail CI
- features/demo.feature only asserts 'the response should be received' (no status/body check), a placeholder-level assertion

**Recommendation:** Add minMsi/minCoveredMsi to infection.json5 (or --min-msi to the Makefile 'infection' target) and a repo-level codecov.yml with explicit project/patch targets; strengthen features/demo.feature to assert a concrete status code and payload.

### adaptability — 4/5

**Evidence:** Env-var driven infra (.env: DB_URL, MESSENGER_TRANSPORT_DSN with commented AMQP/Redis/SQS alternatives, LocalStack endpoints), docker-compose override files (docker-compose.override.yml, docker-compose.prod.yml, docker-compose.load_test.override.yml), YAML-configured API Platform resources (config/api_platform/resources.yaml) keep Domain framework-free (verified src/CompanySubdomain/SomeModule/Domain/ExampleApiResource.php is pure PHP), weekly template-sync workflows push platform changes downstream.

**Gaps:**
- deptrac.yaml layer collectors hardcode placeholder namespaces (CompanySubdomain\SomeModule, Internal\HealthCheck) via enumerated class-suffix regexes, so adapting the template to a real bounded context requires hand-editing regexes that AGENTS.md and the deptrac-fixer skill say not to weaken
- scripts/validate-configuration.sh locks phpinsights.php/psalm.xml/deptrac.yaml/infection.json5/.php-cs-fixer.dist.php with no documented escape hatch for legitimate downstream adaptation

**Recommendation:** Refactor deptrac.yaml collectors to structural directory/layer patterns (e.g. '.*\\Domain\\.*') instead of enumerating placeholder module names, and document in README.md or a new docs/ADAPTING.md the sanctioned way to adapt locked config files (deptrac.yaml, scripts/validate-configuration.sh) when instantiating the template.

### administrability — 3/5

**Evidence:** Rich admin surface in Makefile (cache-clear, cache-warmup, purge, doctrine-migrations-migrate/generate, load-fixtures, setup-test-db/setup-load-test-db, commands, sh, up/down/start/stop); env-var-driven configuration (.env, docker-compose.yml/override/prod with DB/Mercure/SQS settings); scripts/validate-configuration.sh locked-config validation wired into Makefile; dev/prod/load-test compose profiles.

**Gaps:**
- No documented production configuration/administration guide in-repo (secrets rotation, env matrix per environment) — only .env defaults with !ChangeMe! placeholders
- No messenger failure-transport/retry configuration or console-based queue administration story (config/packages/messenger.yaml has empty routing and no failure_transport)
- No feature-flag or runtime-toggle mechanism

**Recommendation:** Add a docs/OPERATIONS.md (or docs/administration.md) covering environment variables, secrets handling, and per-environment config; configure messenger failure_transport + retry_strategy in config/packages/messenger.yaml with messenger:failed:* commands documented; document `make` admin targets in README.

### affordability — 3/5

**Evidence:** Entirely OSS toolchain wrapped in Docker/make (Makefile: FrankenPHP compose stack, LocalStack emulating AWS so local dev/CI incurs no cloud cost); GitHub-hosted ubuntu runners only; AWS K6 runs are opt-in with an explicit `make aws-load-tests-cleanup` target and README warning to avoid charges; free-tier SaaS (Codecov, CodeScene, CodeRabbit). However, ~19 workflows in .github/workflows/ trigger on every PR to main, and almost all of them independently run `make start` which rebuilds the FrankenPHP Docker image from scratch — grep shows the only cache in any workflow is the pnpm cache in eslint.yaml (no docker layer/buildx/composer caching anywhere). Only eslint.yaml has `paths:` filters, so a docs-only PR still runs Infection mutation testing, K6 smoke load tests, Schemathesis, Behat, etc. No `concurrency:` cancellation groups in any workflow.

**Gaps:**
- No Docker layer / composer caching in CI: every one of ~15 PR jobs rebuilds the image from scratch (only pnpm is cached, in eslint.yaml)
- No paths filters on heavy jobs (infection.yml, load-tests.yml, schemathesis.yml, tests.yml) so docs-only changes pay the full matrix
- No concurrency cancellation groups, so force-pushes stack duplicate runs
- Duplicate coverage runs: tests.yml and codecov.yml both run the full PHPUnit coverage suite and upload to Codecov

**Recommendation:** Add a shared image-build job (docker/build-push-action with cache-from/cache-to: type=gha, or a prebuilt CI image in GHCR) that downstream jobs reuse; add `concurrency: {group: ${{ github.workflow }}-${{ github.ref }}, cancel-in-progress: true}` to all PR workflows; add `paths` filters or a changed-files gate for infection.yml, load-tests.yml, schemathesis.yml; merge tests.yml and codecov.yml into one coverage job.

### agility — 4/5

**Evidence:** Makefile (307 lines) exposes a full local fast-feedback loop: `make ci` runs phpcsfixer -> phpmd -> phpinsights -> psalm -> deptrac -> tests -> openapi-diff -> infection; per-PR CI workflows (deptrac.yml, phpinsights.yml, rector.yml, psalm.yml, infection.yml, tests.yml, openapi-diff.yml, graphql-diff.yml) fail fast on drift; contract diffs (OpenAPI/GraphQL snapshots in .github/) enable safe rapid change; dependabot.yml groups all composer deps weekly.

**Gaps:**
- Every CI workflow rebuilds the whole Docker stack via `make start` with no visible layer/composer caching, making the PR feedback loop slow across ~15 separate workflows
- Infection mutation testing runs on every PR with no incremental/changed-files mode (`--git-diff-lines`), adding heavy latency to the merge path

**Recommendation:** Add Docker build caching (docker/build-push-action with GHA cache or composer-cache action) shared across workflows in .github/workflows/*.yml, and switch the PR infection job to incremental mutation testing (infection --git-diff-filter=AM) while keeping full runs on main.

### ai-native-readiness — 4/5

**Evidence:** Best-in-class docs surface for agents: CLAUDE.md (project snapshot, command reference, explicit agent contract 'do not lower quality gates', 'keep Domain framework-free') and AGENTS.md (mandatory workflow, verification baseline command list) are mutually consistent; .claude/skills/ ships 10 skills with valid name/description frontmatter plus AI-AGENT-GUIDE.md, a SKILL-DECISION-GUIDE.md decision tree with combined-scenario routing, and a README index; every skill ends in concrete runnable `make` verification commands. Machine-readable ground truth: .github/openapi-spec/spec.yaml, .github/graphql-spec/spec, workspace.dsl, .spectral.yaml. Guardrails let an agent develop/test/release safely: captainhook pre-commit runs the full gate stack on agent commits, contract drift is caught by openapi-diff/graphql-diff/Schemathesis workflows, and autorelease.yml means a merged conventional commit is a complete safe release path with no manual step.

**Gaps:**
- The key anti-tamper guardrail (scripts/validate-configuration.sh locking phpinsights.php/deptrac.yaml/infection.json5 etc.) is not wired into any GitHub workflow, so an agent that weakens gates and skips local hooks (CAPTAINHOOK_DISABLE) is not stopped by CI
- No automated drift check that AGENTS.md/CLAUDE.md/.claude/skills command lists stay in sync with the Makefile/workflows (issue #171 addressed content sync, but nothing enforces it going forward)
- No .claude/settings.json with pre-approved safe commands (make targets) or hooks, so agent runs still hit permission friction and dangerous commands aren't machine-blocked
- Skills are documentation-only (AGENTS.md says so explicitly) — no executable scripts/reference assets an agent can invoke directly

**Recommendation:** Run scripts/validate-configuration.sh in a required PR workflow; add a small CI lint that greps the make targets cited in AGENTS.md/CLAUDE.md/.claude/skills/*/SKILL.md and fails if any target is missing from the Makefile (prevents doc drift); commit a .claude/settings.json allowlisting the repo's make targets and adding a hook that blocks edits to the locked quality-config files.

### analyzability — 4/5

**Evidence:** Layered analysis stack enforced per PR: Psalm + taint analysis with SARIF upload (.github/workflows/psalm.yml), PHPMD (codesize,design,cleancode), PHPInsights with min-quality/architecture/style=100 and min-complexity=95 (phpinsights.php), Deptrac with --report-uncovered --fail-on-uncovered (Makefile:114), Infection with text+summary logs, codecov coverage, CodeScene/CodeClimate badges in README.md, Structurizr workspace.dsl for architecture visibility.

**Gaps:**
- psalm.xml sets errorLevel="8", the loosest Psalm level, so most type-level defects are invisible despite the otherwise strict gate stack
- infection.json5 and the Makefile infection target set no minMsi/minCoveredMsi, so mutation score can silently degrade without failing CI

**Recommendation:** Tighten psalm.xml errorLevel stepwise toward 1-3 (fix findings, do not baseline-forever), and add "minMsi"/"minCoveredMsi" thresholds to infection.json5 so `make infection` fails on mutation-score regression.

### auditability — 3/5

**Evidence:** Psalm taint results are uploaded as SARIF to GitHub code scanning (.github/workflows/psalm.yml, github/codeql-action/upload-sarif), Caddy access logging is enabled via the log directive in infrastructure/docker/caddy/Caddyfile, php_errors.log is on in config/packages/framework.yaml, CHANGELOG.md is auto-generated on every main push (autorelease.yml), and API contracts are versioned with diff checks (.github/workflows/openapi-diff.yml, graphql-diff.yml).

**Gaps:**
- No structured application logging: monolog is not installed and there is no JSON log formatter for machine-parseable trails
- No request/correlation ID propagation or log-shipping/retention guidance (no OpenTelemetry, no ELK/CloudWatch config despite LocalStack in docker-compose.yml)
- No domain-event audit trail persistence despite the event bus scaffolding in src/Shared/Domain/Bus/Event

**Recommendation:** Install symfony/monolog-bundle with JSON formatting to stderr in config/packages/monolog.yaml, add a request-id middleware (e.g. symfony/uid + a processor) so every log line is correlatable, and document log retention/shipping (CloudWatch via the existing LocalStack setup) in README.md; optionally persist domain events from src/Shared/Infrastructure/Bus/Event as an audit table with a Doctrine migration.

### autonomy — 4/5

**Evidence:** High degree of unattended operation: .github/workflows/autorelease.yml auto-versions, generates CHANGELOG.md and creates GitHub releases on every push to main via conventional commits; code-lint-and-prettify.yml auto-fixes style and applies Rector, then commits and pushes the result (GPG-signed when key present); graphql-diff.yml auto-regenerates and commits the GraphQL spec on PRs; template-sync-app.yml (weekly cron) and tempate-sync-pat.yml (monthly cron) automatically open sync PRs into downstream repos; .github/dependabot.yml runs grouped weekly composer and monthly npm updates; .coderabbit.yaml enables automated AI review with request_changes_workflow.

**Gaps:**
- No auto-merge for green Dependabot/template-sync PRs — every automated PR still needs the single hardcoded reviewer ('Kravalg' in dependabot.yml)
- No scheduled CI run on main (all quality workflows are pull_request-only), so the repo cannot autonomously detect bit-rot or new dependency CVEs between PRs
- Dependabot does not cover github-actions or docker ecosystems, leaving action/base-image updates to humans

**Recommendation:** Add a dependabot auto-merge workflow (gh pr merge --auto gated on required checks), a scheduled (cron) workflow running `make ci` + `make check-security` on main, and extend .github/dependabot.yml with `github-actions` and `docker` ecosystems.

### availability — 3/5

**Evidence:** Health probes are layered and real: Caddy /ping endpoints on :80/:443 and :8081 (infrastructure/docker/caddy/Caddyfile), a /api/health application endpoint (src/Internal/HealthCheck/Application/Controller/HealthCheckController.php) that actively checks DB (SELECT 1), cache, and SQS broker via event subscribers; Docker HEALTHCHECK in Dockerfile:43; compose healthchecks with interval/timeout/retries and depends_on database condition: service_healthy plus restart: unless-stopped (docker-compose.yml). K6 health scenario asserts 204 with p(99) latency and >99% check-rate thresholds (tests/Load/utils/thresholdsBuilder.js), smoke run enforced in CI (.github/workflows/load-tests.yml).

**Gaps:**
- docker-compose.prod.yml is only 9 lines of env overrides — no replicas, no resource limits, no HA/scale-out or orchestrator (K8s/ECS) deployment guidance anywhere
- Single PHP node and single Postgres instance; no load-balancing or multi-instance topology even documented
- No uptime monitoring/alerting hooks (no metrics endpoint, no Prometheus exporter, no SLO definition)
- Health endpoint is all-or-nothing 204/500 with no per-dependency status payload for LB routing decisions

**Recommendation:** Extend docker-compose.prod.yml with deploy.replicas, resource limits and a documented HA topology (or add infrastructure/k8s/ manifests with liveness/readiness probes mapped to /ping and /api/health); add a deployment view with redundancy notes to workspace.dsl; document an availability/SLO section in README.md and wire a metrics endpoint (e.g. prometheus exporter) for uptime alerting.

### compatibility — 4/5

**Evidence:** Backward-compatibility is actively guarded: .github/workflows/openapi-diff.yml and graphql-diff.yml regenerate specs on every PR and diff against origin/main via scripts/openapi-diff.sh (openapitools/openapi-diff:2.1.2); .github/workflows/schemathesis.yml validates the running API against .github/openapi-spec/spec.yaml; composer.json pins a platform of PHP 8.3.12 and conflicts with symfony/symfony; specs are versioned artifacts under .github/openapi-spec/ and .github/graphql-spec/.

**Gaps:**
- scripts/openapi-diff.sh invokes openapi-diff without --fail-on-incompatible/--fail-on-changed, so a breaking API change prints a diff but may not fail the CI job
- composer.json declares php >=8.2 but CI only exercises PHP 8.3 (single FrankenPHP 8.3.17 image); no PHP version matrix backs the claimed 8.2 compatibility
- composer.json requires symfony/framework-bundle 7.2.* and symfony/translation 7.2.* while sibling packages are 7.3.* — inconsistent version constraints

**Recommendation:** Add --fail-on-incompatible to the openapi-diff invocation in scripts/openapi-diff.sh so breaking changes hard-fail CI; add a PHP 8.2/8.3 matrix (or drop >=8.2 from composer.json to match reality); align all symfony/* constraints to 7.3.* in composer.json.

### composability — 4/5

**Evidence:** Symfony DI with autowire/autoconfigure plus tagged-service composition in config/services.yaml (_instanceof tags app.command_handler/app.event_subscriber wired into InMemorySymfonyCommandBus/InMemorySymfonyEventBus via MessageBusFactory and CallableFirstParameterExtractor); small composable ports in src/Shared/Domain/Bus (CommandBusInterface, EventBusInterface, DomainEventSubscriberInterface) and API Platform state providers (ExampleApiResourceProvider implements ProviderInterface).

**Gaps:**
- CQRS is only half-modelled: there is a Command bus and Event bus but no Query bus/QueryHandlerInterface in src/Shared/Domain/Bus, so read-side composition has no first-class port (deptrac.yaml regexes also omit Query* types)
- Only one sample module composes these primitives, so multi-module composition (cross-context events, module wiring) is not demonstrated

**Recommendation:** Add a Query side to src/Shared/Domain/Bus (QueryInterface, QueryHandlerInterface, QueryBusInterface + InMemorySymfonyQueryBus in Shared/Infrastructure/Bus/Query), register the tag in config/services.yaml, cover it in deptrac.yaml collectors, and show a second thin module (or extend Internal/HealthCheck) using it.

### confidentiality — 2/5

**Evidence:** .gitignore excludes /.env.local and /.env.*.local; docker-compose.prod.yml takes APP_SECRET and CADDY_MERCURE_JWT_SECRET strictly from the environment with no defaults; the prod Dockerfile stage runs composer dump-env prod; sessions use cookie_secure: auto and cookie_samesite: lax (config/packages/framework.yaml).

**Gaps:**
- No authentication or authorization at all: config/packages/security.yaml does not exist, symfony/security-bundle is not installed, and no firewall/voter/IsGranted usage exists in src/
- Committed .env contains APP_SECRET=2e222659c5b006df8d0e68cc33913706 and default Mercure JWT secret placeholders, and the Caddyfile enables anonymous Mercure subscriptions
- No secrets-manager integration or guidance (LocalStack is present but no AWS Secrets Manager/SSM usage), and no secrets scanning to catch leaked credentials

**Recommendation:** Add symfony/security-bundle with a template config/packages/security.yaml (stateless firewall + access_control examples for API Platform), replace committed .env secrets with obvious CHANGE_ME placeholders plus a bin/ script to generate APP_SECRET, remove the anonymous directive default from infrastructure/docker/caddy/Caddyfile, and document AWS Secrets Manager wiring against the existing LocalStack service in docker-compose.yml.

### configurability — 4/5

**Evidence:** .env/.env.test externalize DB (DB_URL composed from DB_USER/DB_PASSWORD/DB_NAME), SQS/LocalStack (AWS_SQS_*), Mercure secret, ports; config/services.yaml resolves %env()% for the SqsClient; env-specific service files (services_prod.yaml, services_test.yaml) and per-package YAML under config/packages/; docker-compose override files select dev/prod/load-test stacks; Makefile parametrized (SCHEMATHESIS_URL ?=, base_ref, CI=1 switches).

**Gaps:**
- No documented reference of all supported environment variables (README.md and AGENTS.md never enumerate them; wiki is external), so downstream operators must reverse-engineer .env and docker-compose files
- Some settings remain semi-hardcoded, e.g. SQS endpoint built from AWS_SQS_ENDPOINT_BASE:LOCALSTACK_PORT in config/services.yaml assumes the LocalStack topology rather than a plain endpoint URL

**Recommendation:** Add a docs/CONFIGURATION.md (or README section) tabulating every env var with default/purpose/prod guidance, and make the SqsClient endpoint a single AWS_SQS_ENDPOINT env var with a processor default in config/services.yaml so real AWS endpoints need no code change.

### convenience — 4/5

**Evidence:** Makefile wraps the entire lifecycle in ~50 targets: `make start`, `make install`, `make sh`, `make logs`, `make ci` (full local pipeline: phpcsfixer, psalm, deptrac, tests, infection, openapi diff), `make setup-test-db`, load-test targets with automatic stack setup/teardown (RUN_LOAD_TEST define with trap cleanup), and CI/local duality via the CI=1 env switch. captainhook.json provides git hooks; symfony/maker-bundle is included for scaffolding.

**Gaps:**
- Several targets lack `##` help annotations (generate-openapi-spec, generate-graphql-spec, build-k6-docker, build-spectral-docker, ci-static-analysis, ci-deptrac, ci-tests-and-openapi, ci-mutation) so they are invisible in `make help` despite being referenced by CLAUDE.md/AGENTS.md
- No devcontainer or one-shot bootstrap target that chains start + install + setup-test-db for first-time users

**Recommendation:** Add `## description` comments to every undocumented Makefile target so `make help` shows the full surface, and add a `make bootstrap` target chaining start/install/setup-test-db documented in README.md Quick start.

### correctness — 4/5

**Evidence:** Multi-layer correctness gates run on every PR to main: tests.yml (PHPUnit unit+integration with coverage, fail_ci_if_error: true), E2Etests.yml (Behat), schemathesis.yml (contract testing), infection.yml (mutation), psalm.yml, deptrac.yml (with --report-uncovered --fail-on-uncovered in Makefile), rector.yml, plus bats-tests.yml validating the Makefile itself (tests/CLI/bats/ has 8 .bats suites). 23 PHPUnit test files (18 unit, 3 integration) mirror the src/ layout (CompanySubdomain, Internal, Shared).

**Gaps:**
- Mutation testing is informational only: without minMsi in infection.json5, Infection exits 0 even when mutants survive, so the 'Mutation testing' CI check cannot fail on weak tests
- No enforced code-coverage threshold anywhere in the repo (phpunit.xml.dist defines the coverage include set but no requirements; no root codecov.yml with targets)

**Recommendation:** Gate correctness numerically: set minMsi/minCoveredMsi in infection.json5 and add a codecov.yml (or phpunit coverage check script) with explicit fail-under targets, then mark both checks required on main.

### credibility — 4/5

**Evidence:** README.md carries external verifiable signals: CodeScene code health, Codecov coverage, CodeClimate maintainability, PHPInsights 100% badges; most third-party actions are SHA-pinned with version comments (e.g. actions/checkout@34e11487... in symfony.yml, tests.yml, schemathesis.yml); releases are automated with conventional changelogs (autorelease.yml); LICENSE, CONTRIBUTING.md, SECURITY.md, issue/PR templates, and Dependabot all exist; bot commits are GPG-signed (code-lint-and-prettify.yml).

**Gaps:**
- SECURITY.md is a stub: 'Known vulnerabilities: TBD' with no supported-versions table, disclosure SLA, or scope
- A few actions are tag-pinned rather than SHA-pinned (actions/checkout@v4 and crazy-max/ghaction-import-gpg@v6 in code-lint-and-prettify.yml, AndreasAugustin/actions-template-sync@v2 in both template-sync workflows, github/codeql-action/upload-sarif@v3.25.4 in psalm.yml)
- No OpenSSF Scorecard/Best-Practices badge and no signed/attested releases (SLSA provenance)

**Recommendation:** Flesh out SECURITY.md with supported versions, response SLA, and scope; SHA-pin the remaining tag-pinned actions in code-lint-and-prettify.yml, tempate-sync-pat.yml, template-sync-app.yml, psalm.yml; add the ossf/scorecard-action workflow with its badge in README.md and generate SLSA provenance/signed release artifacts in autorelease.yml.

### customizability — 3/5

**Evidence:** The template ships an explicit placeholder bounded context (src/CompanySubdomain/SomeModule with ExampleApiResource whose description literally says 'Replace this placeholder endpoint with a real bounded-context API resource'), YAML-based API Platform resource config, and skills (.claude/skills/api-platform-crud/SKILL.md) describing how to add resources.

**Gaps:**
- No customization guide anywhere (grep of README.md/CONTRIBUTING.md/AGENTS.md finds zero mentions of renaming CompanySubdomain/SomeModule); a new service owner gets no checklist for renaming the placeholder namespace, composer.json name, workspace.dsl, and deptrac.yaml together
- deptrac.yaml hardcodes the placeholder namespaces in regexes while AGENTS.md and the deptrac-fixer skill forbid editing deptrac.yaml, creating a contradictory rule the first real customization must break
- composer.json still carries template identity (name 'vilnacrm/php-serice-template' — also a typo, 'serice') with no instruction to change it

**Recommendation:** Add a TEMPLATE_CUSTOMIZATION.md (linked from README.md 'Quick start') with a step-by-step bootstrap checklist: rename src/CompanySubdomain/SomeModule, update composer.json name/description, deptrac.yaml collectors, workspace.dsl, config/api_platform/resources.yaml, and .env secrets; optionally provide a scripts/bootstrap-service.sh that performs the rename automatically; fix the composer.json name typo.

### debuggability — 3/5

**Evidence:** Xdebug 3.4.2 compiled from verified source into the dev image (Dockerfile lines 69-99), toggled via XDEBUG_MODE env in docker-compose.override.yml, client_host preconfigured in infrastructure/docker/php/conf.d/app.dev.ini; make logs/new-logs/sh targets; coverage via XDEBUG_MODE=coverage; deptrac-debug target; CADDY_DEBUG hook in Caddyfile.

**Gaps:**
- No symfony/web-profiler-bundle, symfony/debug-bundle, or var-dumper in require-dev — no profiler toolbar or dump server for dev debugging
- No monolog, so no debug log channels or per-channel verbosity to inspect application behavior
- No step-debugging documentation (IDE setup, start_with_request) beyond ini comments

**Recommendation:** Add symfony/web-profiler-bundle and symfony/debug-bundle to require-dev with when@dev config under config/packages/, add monolog with a dev debug channel, and add a short docs section (README or .claude/skills/testing-workflow) on attaching Xdebug from popular IDEs via XDEBUG_MODE=debug.

### degradability — 2/5

**Evidence:** Only rudimentary traces: dependency checks are decomposed into independent subscribers (DBCheckSubscriber, CacheCheckSubscriber, BrokerCheckSubscriber under src/Internal/HealthCheck/Application/EventSub/), restart: unless-stopped lets an orchestrator route around a dead container, and prod Doctrine query/result caches (config/packages/doctrine.yaml when@prod) reduce DB pressure.

**Gaps:**
- No circuit breakers, timeouts, bulkheads, or fallback paths anywhere in src/ or config/
- Any single subscriber exception makes /api/health throw a 500 — no partial/degraded health status (e.g. cache down but DB up)
- No rate limiting (symfony/rate-limiter not installed) or load-shedding configuration
- No documentation of degraded-mode behavior

**Recommendation:** Make HealthCheckController catch per-subscriber failures and return a component-status payload distinguishing critical (DB) from non-critical (cache) dependencies; add symfony/rate-limiter config as a template default; add a circuit-breaker example (e.g. around the SQS client) and document degradation semantics in README.md.

### demonstrability — 4/5

**Evidence:** The template can demonstrate working behavior end-to-end: Gherkin features (features/health_check.feature with 4 human-readable scenarios including cache/DB/broker failure modes) serve as living documentation; exported OpenAPI (.github/openapi-spec/spec.yaml via make generate-openapi-spec) and GraphQL specs are regenerated and diffed in CI; README.md documents the full toolchain (PHPUnit, Behat, Bats, Infection, K6) and the local demo entrypoint http://localhost:8081; 'make ci' reproduces the whole verification stack locally.

**Gaps:**
- Behat surface is thin for demonstration purposes: only 2 feature files, one of which (demo.feature) is a scaffold-installation smoke check rather than a demonstrated business capability
- No published/demonstrable coverage or MSI badge/report artifact committed or linked with enforced numbers (README lists tools but not achieved metrics)

**Recommendation:** Add one realistic CRUD resource feature (per the api-platform-crud skill) with full Behat scenarios demonstrating the template's DDD/CQRS pattern, and surface Codecov/Infection badges with enforced targets in README.md.

### dependability — 4/5

**Evidence:** Verification stack is enterprise-grade and CI-enforced on every PR: unit+integration with coverage to Codecov (.github/workflows/tests.yml, codecov.yml), Behat E2E (E2Etests.yml), Infection mutation testing (infection.yml), Schemathesis spec-conformance fuzzing (schemathesis.yml), Psalm, PHPInsights, Deptrac, Rector, OpenAPI/GraphQL diff gates; k6 smoke load tests in CI; pinned action SHAs and pinned schemathesis image digest (Makefile:13); CLAUDE.md contract forbids lowering quality gates.

**Gaps:**
- Runtime dependability is much weaker than build-time: no structured logging (Monolog absent from config/bundles.php and composer.json), no messenger retry/failure transport, no monitoring/tracing
- make infection runs without --min-msi/--min-covered-msi so the mutation gate cannot actually fail on regressions (Makefile:178-179)

**Recommendation:** Add --min-msi and --min-covered-msi thresholds to the infection target in Makefile and infection.json5; add symfony/monolog-bundle with JSON stderr handler in config/packages/monolog.yaml; configure messenger retry_strategy + failure_transport in config/packages/messenger.yaml so runtime dependability matches the CI verification rigor.

### deployability — 3/5

**Evidence:** Dockerfile is a proper multi-stage build (composer, php_extension_installer, frankenphp_base, frankenphp_dev, frankenphp_prod) with a hardened prod stage (USER www-data, php.ini-production, app.prod.ini, HEALTHCHECK on /ping); docker-compose.prod.yml provides a prod override; infrastructure/docker/php/docker-entrypoint.sh waits for the DB and auto-runs doctrine migrations; compose healthchecks gate startup ordering.

**Gaps:**
- No CD pipeline at all: no workflow in .github/workflows/ builds and pushes the image to any registry (no docker/build-push-action, no GHCR/ECR publish), and no deploy workflow exists
- No runtime deployment manifests: infrastructure/ contains only local docker bits — no Kubernetes/Helm/ECS/Terraform definitions for running the service (only tests/Load AWS scripts for load-testing infra)
- No deployment documentation (rollout, rollback, secrets management beyond compose env defaults with !ChangeMe! placeholders)

**Recommendation:** Add a .github/workflows/docker-publish.yml using docker/build-push-action to build the frankenphp_prod target and push tagged images to GHCR on release (wired to autorelease.yml tags), add a minimal reference deployment (Helm chart or ECS/Terraform module under infrastructure/), and document the deploy/rollback path in README.md or docs/DEPLOYMENT.md.

### determinability — 4/5

**Evidence:** Each quality concern is a separately named PR status check (20 workflow files under .github/workflows/), so failure cause is immediately determinable; test state is deterministic per run via 'make setup-test-db' (drop --force --if-exists, create, migrate --no-interaction); phpunit.xml.dist forces APP_ENV=test and error_reporting=-1 with display_errors=1; schemathesis.yml has an explicit readiness probe loop that dumps 'docker compose logs php database localstack' on timeout, making failures diagnosable.

**Gaps:**
- Unit test data is not determinable across runs: tests/Unit/UnitTestCase.php creates Faker via Factory::create() with no seed, so a failure's exact input may not be knowable after the fact
- PHPUnit lacks strictness/diagnostic settings (no failOnRisky/failOnWarning, no cacheResult/order seed printing) that make test-outcome classification unambiguous

**Recommendation:** Seed Faker in tests/Unit/UnitTestCase.php (e.g., Factory::create() then $this->faker->seed(fixed or logged seed)) and add failOnRisky="true" failOnWarning="true" to phpunit.xml.dist.

### discoverability — 4/5

**Evidence:** `make help` is .DEFAULT_GOAL and auto-generates a target list from `##` comments; README.md lists all local entry-point URLs (REST docs at /api/docs, GraphQL, Structurizr Lite, load-test endpoint); .claude/skills/SKILL-DECISION-GUIDE.md provides an explicit decision tree; AGENTS.md and CLAUDE.md give ordered reading paths; .github has issue templates, pull_request_template.md, AUTORELEASE.md, and TEMPLATE_SYNC_*.md docs.

**Gaps:**
- Undocumented make targets (generate-openapi-spec, generate-graphql-spec, build-*-docker, ci-* subtargets) are hidden from `make help`
- Troubleshooting and deep docs live only on the external GitHub wiki, not discoverable offline in-repo
- SECURITY.md 'Known vulnerabilities' section is a bare 'TBD'

**Recommendation:** Annotate all Makefile targets with `##` help text, create an in-repo docs/ directory (or expand README) with the troubleshooting content currently only on the wiki, and replace the 'TBD' section in SECURITY.md with real content (supported versions table, disclosure SLA).

### distributability — 3/5

**Evidence:** The service is fully containerized (multi-stage Dockerfile: frankenphp_base/dev/prod, non-root www-data prod stage) with 12-factor env-based config (.env + composer dump-env), an SQS Messenger transport exercised against localstack (docker-compose.yml), Mercure+Vulcain in the Caddyfile for distributed real-time/preload clients, and a genuinely distributed load-testing capability on AWS (tests/Load/aws-execute-load-tests.sh, user-data.sh, s3-*-policy.json, trust-policy.json).

**Gaps:**
- The AWS automation only distributes the K6 test rig, not the service itself — there is no IaC (Terraform/CDK/k8s) or multi-node deployment path for the application
- Node-local state blocks distribution: Mercure bolt:///data/mercure.db, caddy_data/caddy_config volumes, filesystem app cache (cache.yaml commented out), and native session storage (framework.yaml) all pin a request to one node

**Recommendation:** Ship a distributed deployment reference: externalize Mercure to a standalone hub URL, move sessions and cache.app to Redis in when@prod, and add minimal IaC (Terraform module or k8s manifests under infrastructure/) demonstrating the service running on more than one node behind a load balancer, documented in README.md and workspace.dsl.

### durability — 2/5

**Evidence:** Postgres data persists in a named volume db_data (docker-compose.yml:50), Mercure/Caddy state in caddy_data; schema changes are versioned via Doctrine Migrations (migrations/Version20240121122200.php, config/packages/doctrine_migrations.yaml) and applied idempotently at startup (infrastructure/docker/php/docker-entrypoint.sh:51-53).

**Gaps:**
- Zero backup story: no pg_dump/WAL-archiving/PITR scripts, no volume backup guidance, and no *.md file mentions backup/restore at all (grep for backup|restore|disaster returned nothing)
- No DB replication or managed-database (RDS/Aurora) guidance for production
- App cache defaults to filesystem (config/packages/cache.yaml is entirely commented out) despite workspace.dsl modeling Redis
- Migrations auto-run with --no-interaction at container start without a pre-migration backup or dry-run safety step

**Recommendation:** Add a docs/operations/backup-restore.md (pg_dump + WAL archiving or managed-DB snapshot guidance), a make db-backup/db-restore pair in Makefile, guidance to run migrations as an explicit deploy step (not on every container boot) with backup-before-migrate, and uncomment/configure a Redis cache adapter in config/packages/cache.yaml to match workspace.dsl.

### effectiveness — 4/5

**Evidence:** The defect-catching net is broad and largely automated: mutation testing (infection.yml), property/contract fuzz-adjacent testing (Schemathesis --checks all), taint analysis (make psalm-security), architectural drift detection (deptrac --fail-on-uncovered), OpenAPI/GraphQL diff gates, k6 smoke load tests with hard thresholds on every PR (load-tests.yml), and bats tests that verify the build tooling itself.

**Gaps:**
- The single most effective enforcement lever is disconnected: Infection runs with --show-mutations -j8 (Makefile line 179) but no --min-msi, so surviving mutants never fail a PR
- Coverage upload to Codecov has fail_ci_if_error (upload failures only); no in-repo coverage target means untested new code can merge silently

**Recommendation:** Turn Infection and coverage from reporting into gates: add minMsi (e.g., start at current baseline) to infection.json5 and patch-coverage targets via a root codecov.yml; issue #11 (RESTler fuzzing/Akto) already tracks the remaining dynamic-testing effectiveness gap.

### efficiency — 4/5

**Evidence:** Production runtime is well tuned: infrastructure/docker/php/conf.d/app.prod.ini sets opcache.preload=/srv/app/config/preload.php, opcache.validate_timestamps=0, opcache.memory_consumption=256, max_accelerated_files=20000; app.ini tunes realpath cache and interned strings per the Symfony performance guide. Dockerfile (FrankenPHP 1 / php8.3 alpine) installs apcu+redis+opcache, runs composer dump-autoload --classmap-authoritative and composer dump-env prod. Caddyfile enables zstd/gzip encoding and Vulcain. config/packages/doctrine.yaml wires query_cache_driver and result_cache_driver to dedicated cache pools in prod.

**Gaps:**
- FrankenPHP worker mode is not enabled: the Caddyfile only has an empty {$FRANKENPHP_CONFIG} placeholder, no worker script exists, and composer.json lacks runtime/frankenphp-symfony, so the template runs classic per-request mode despite shipping FrankenPHP
- config/packages/cache.yaml is entirely commented out — the app cache defaults to filesystem; Redis/APCu adapters are only hinted at in comments and no Redis service exists in docker-compose.yml even though the redis PHP extension is installed

**Recommendation:** Enable FrankenPHP worker mode as the prod default: add runtime/frankenphp-symfony to composer.json, populate FRANKENPHP_CONFIG with a worker directive pointing at public/index.php in docker-compose.prod.yml, and document opt-out. Wire config/packages/cache.yaml to cache.adapter.redis in when@prod (adding a redis service to docker-compose.yml) so the installed redis extension and Doctrine cache pools use a real shared backend.

### elasticity — 2/5

**Evidence:** Only indirect support exists: the K6 spike profile (tests/Load/config.json.dist, ramping-arrival-rate 0→200 RPS in scenariosBuilder.js) verifies the service survives sudden load swings, and docker-compose.yml defines healthchecks (start_period 180s, /ping) plus restart: unless-stopped that an orchestrator could use for scale decisions.

**Gaps:**
- No autoscaling mechanism or configuration anywhere: no HPA/KEDA, no ECS service auto scaling, no compose scale guidance
- Stateful local resources (Mercure bolt DB, filesystem cache/sessions, caddy volumes) prevent instances from being added/removed elastically
- No queue-based buffering under burst: messenger routing is empty, so spikes hit the request path synchronously
- No documentation of an elasticity strategy in README.md, AGENTS.md, or workspace.dsl

**Recommendation:** Make the template elastically deployable: remove node-local state (Redis cache/sessions, external Mercure hub), route burst-prone work through the already-configured SQS transport with a scalable messenger:consume worker, and provide an autoscaling reference (k8s HPA on CPU/RPS or ECS target-tracking policy) under infrastructure/ with the strategy documented in workspace.dsl and README.md.

### evolvability — 4/5

**Evidence:** Rector configured with full evolution sets (withPhpSets, deadCode/codeQuality/typeDeclarations/symfonyCodeQuality etc. in rector.php) and enforced dry-run per PR (.github/workflows/rector.yml); dependabot.yml groups composer deps weekly and npm (tests/Load) monthly; Doctrine Migrations for schema evolution; autorelease.yml + conventional commits (captainhook.json, ramsey/conventional-commits) + CHANGELOG.md; template-sync workflows propagate evolution to downstream repos; OpenAPI/GraphQL diff workflows guard contract evolution.

**Gaps:**
- composer.json pins aging dependencies: phpunit/phpunit ^9.5 (two majors behind), symfony/proxy-manager-bridge ^6.4 (legacy bridge in a Symfony 7 app), and mixed symfony constraints (framework-bundle 7.2.* / translation 7.2.* vs 7.3.* siblings), showing upgrade debt inside the evolution machinery itself
- No documented deprecation/upgrade policy for downstream services consuming template syncs (TEMPLATE_SYNC_*.md cover mechanics, not versioning/breaking-change policy)

**Recommendation:** Upgrade phpunit to ^11, drop symfony/proxy-manager-bridge, align all symfony/* constraints to 7.3.*; add an UPGRADING.md describing the template's semver/breaking-change policy for downstream consumers of the template-sync workflows.

### extensibility — 4/5

**Evidence:** Clear extension seams: new bounded contexts under src/<Subdomain>/<Module>/{Domain,Application,Infrastructure}, tagged-service buses auto-register new CommandHandlerInterface/DomainEventSubscriberInterface implementations via _instanceof in config/services.yaml, API Platform resources added declaratively in config/api_platform/resources.yaml, symfony/maker-bundle in require-dev, OpenApiFactory decorator pattern for spec extension, and the api-platform-crud skill documents the add-a-resource workflow.

**Gaps:**
- Extending with a new module requires manually appending new className regexes to deptrac.yaml for every namespace-type combination (the collectors enumerate suffixes like Transformer|Command|CommandHandler|... per module), a brittle and undocumented step
- No scaffolding for a new bounded context (no maker command or script that generates the Domain/Application/Infrastructure skeleton plus deptrac/workspace.dsl entries)

**Recommendation:** Replace enumerated deptrac.yaml collectors with structural regexes matching any module ('App\\.*\\Domain\\.*' etc.) so new modules are covered automatically, and add a `make new-module name=...` script (scripts/new-module.sh) that scaffolds the three-layer skeleton with a passing example test.

### failure transparency — 3/5

**Evidence:** API errors are RFC 7807 compliant (rfc_7807_compliant_errors: true and jsonproblem error format in config/packages/api_platform.yaml); health check failure documented as 500 response in config/api_platform/resources.yaml; php_errors.log: true in config/packages/framework.yaml; Caddy access logging enabled (log directive in Caddyfile); entrypoint prints explicit DB-unreachable diagnostics and exits non-zero; bus wrappers surface root causes (InMemorySymfonyEventBus unwraps HandlerFailedException, CommandNotRegisteredException/EventNotRegisteredException give named failures).

**Gaps:**
- No Monolog/structured JSON logging — no channels, no log levels, no correlation/request IDs (monolog absent from composer.json and config/packages/)
- No error-tracking integration (Sentry or similar) even as a commented template option
- No distributed tracing/OpenTelemetry despite the service being SQS-async and microservice-oriented
- Health endpoint returns bare 204/500 with no body identifying which dependency failed

**Recommendation:** Add symfony/monolog-bundle with a JSON stderr formatter and request-id processor in config/packages/monolog.yaml, an optional Sentry DSN env hook, OpenTelemetry instrumentation guidance, and enrich /api/health to return per-check status in the failure body.

### familiarity — 4/5

**Evidence:** The repo follows stock Symfony Flex conventions (config/packages/*.yaml with ###> flex markers in .env, bin/console, symfony.lock, composer.json/lock), standard GitHub community files (CONTRIBUTING.md, ISSUE_TEMPLATE, PR template, dependabot.yml), Conventional Commits with documented autorelease (.github/AUTORELEASE.md), and ubiquitous tooling (Makefile, docker compose, PHPUnit, Behat, K6).

**Gaps:**
- Makefile uses a nonstandard `.RECIPEPREFIX +=` (space-indented recipes), which silently breaks the muscle memory of anyone editing it with conventional tab-indented rules
- The hexagonal/DDD src layout (CompanySubdomain/SomeModule/{Application,Domain,Infrastructure}) diverges from the default Symfony structure with no in-repo ARCHITECTURE.md explaining the mapping (only workspace.dsl and deptrac.yaml imply it)

**Recommendation:** Add a short ARCHITECTURE.md (or README section) that maps the DDD/hexagonal directory layout to familiar Symfony concepts and explains the layer rules enforced by deptrac.yaml, and add a comment in the Makefile header warning about the space-based .RECIPEPREFIX.

### fault-tolerance — 3/5

**Evidence:** Concrete but shallow mechanisms: DB readiness wait loop with 60 retries in infrastructure/docker/php/docker-entrypoint.sh:32-49; compose healthchecks with retries (10 for Postgres) and depends_on service_healthy gating; restart: unless-stopped self-healing; test messenger transport falls back to in-memory (config/packages/messenger.yaml when@test).

**Gaps:**
- config/packages/messenger.yaml has no retry_strategy, no failure_transport, and no dead-letter queue for the SQS transport — a failed async message is simply lost
- No HTTP-client retry/timeout configuration (framework.yaml has no http_client section)
- No transactional-outbox or idempotency pattern examples for the CQRS buses
- SQS client calls in BrokerCheckSubscriber have no timeout/backoff configuration

**Recommendation:** Configure messenger retry_strategy (max_retries, exponential multiplier) plus a failure_transport DLQ in config/packages/messenger.yaml and wire the SQS DLQ into infrastructure/docker/php/init-aws.sh; add default http_client timeout/retry_failed config in config/packages/framework.yaml as template defaults.

### fidelity — 4/5

**Evidence:** Tests exercise realistic infrastructure, not stubs of it: integration/Behat tests run inside the FrankenPHP container against real Postgres via migrations (make setup-test-db); load tests run against the production compose stack (docker-compose.prod.yml + docker-compose.load_test.override.yml with php/database/localstack, Makefile RUN_LOAD_TEST); Schemathesis hits the live HTTP endpoint at localhost:8081; the same Docker images (Dockerfile: dunglas/frankenphp:1-php8.3.17-alpine) back dev, CI, and prod targets.

**Gaps:**
- Behat failure-mode scenarios ('the cache is not working', 'the database is not available') are simulated via test doubles in contexts rather than real fault injection, so dependency-failure fidelity is partial
- Unit/integration suites run under APP_ENV=test while only load tests use the prod image path, so prod-config regressions (opcache/env wiring) are only covered by the k6 smoke path

**Recommendation:** Add a lightweight prod-image smoke check in CI (boot docker-compose.prod.yml and curl /api/health) and consider one real fault-injection scenario (stop the database container mid-Behat) to validate the health endpoint against genuine failures.

### flexibility — 4/5

**Evidence:** Dual API paradigms (REST + GraphQL via API Platform 4, both with exported specs in .github/), messenger transport swappable via MESSENGER_TRANSPORT_DSN (SQS default, AMQP/Redis examples in .env), three docker-compose profiles (dev override, prod, load-test), K6 scenarios parameterized (execute-load-tests-script with scenario/runSmoke/... args), Makefile CI=1 switch runs the same targets containerized or bare, SCHEMATHESIS_URL overridable for remote targets.

**Gaps:**
- Database flexibility is nominal: .env comments show sqlite/mysql alternatives but the stack, migrations, and load-test tooling assume PostgreSQL 16 with no guidance for switching
- PHPMailer is a hard runtime dependency in composer.json with no abstraction/port around mailing, constraining transport choice

**Recommendation:** Either document PostgreSQL as the supported engine (removing misleading commented DSNs from .env) or verify migrations are engine-agnostic; wrap mailing behind a Shared/Domain port with a PHPMailer adapter in Infrastructure so the transport is swappable.

### inspectability — 3/5

**Evidence:** Exported, versioned OpenAPI (.github/openapi-spec/spec.yaml) and GraphQL (.github/graphql-spec/spec) contracts with diff/validation CI (openapi-diff.yml, graphql-diff.yml, schemathesis.yml); live API docs at /api/docs; Structurizr Lite container serving workspace.dsl diagrams; /api/health endpoint and /ping; `make commands` lists console commands.

**Gaps:**
- Health endpoint returns bare 204 (HealthCheckController) — no per-dependency status payload to inspect what is degraded
- No metrics endpoint or runtime statistics exposure (no Prometheus exporter, no FrankenPHP/Caddy metrics enabled)
- No admin/introspection surface for the SQS message queue state

**Recommendation:** Extend HealthCheckController to return a JSON body with per-check status (db/cache/broker, duration) on a detailed variant (e.g. /health/detail), and enable Caddy/FrankenPHP metrics (servers > metrics in Caddyfile global options) exposing a /metrics endpoint.

### installability — 4/5

**Evidence:** Single-command bootstrap: README.md Quick start is `make start` (docker compose up --detach --wait); docker-entrypoint.sh auto-installs composer dependencies, waits up to 60s for PostgreSQL, and runs migrations; .env ships working defaults (DB, LocalStack, Mercure); Makefile has `make help` self-documentation and `make install`; docker-compose.override.yml auto-provisions Structurizr and LocalStack for dev.

**Gaps:**
- Git submodules (.gitmodules: bats-assert, bats-support under tests/CLI/) require `git submodule update --init` which is not mentioned in the README quick start, so `make bats` fails on a fresh clone
- No devcontainer.json / Codespaces configuration despite the repo shipping an AI/cloud-agent-oriented workflow
- No preflight check for host prerequisites (Docker Engine/Compose versions) beyond a doc link

**Recommendation:** Add .devcontainer/devcontainer.json reusing the frankenphp_dev target, document (or automate in `make start`) submodule initialization, and add a `make doctor` preflight target validating Docker/Compose versions.

### integrity — 4/5

**Evidence:** composer.lock and symfony.lock are committed with make composer-validate run in CI (symfony.yml); Doctrine Migrations manage schema (migrations/, config/packages/doctrine_migrations.yaml); architecture boundaries are CI-enforced via deptrac.yml/deptrac.yaml; API backward compatibility is CI-checked (openapi-diff.yml, graphql-diff.yml against .github/openapi-spec and .github/graphql-spec); Infection mutation testing guards test integrity (infection.yml, infection.json5); the Dockerfile GPG-verifies the Xdebug source tag before building; most actions are SHA-pinned.

**Gaps:**
- CSRF protection is commented out in config/packages/framework.yaml (acceptable for a stateless API but undocumented as a decision)
- No build artifact/container image signing (cosign) or SBOM generation, so downstream consumers cannot verify image provenance
- No Symfony Validator constraint examples in src/ (validator.yaml exists but the template ships no input-validation pattern to copy)

**Recommendation:** Add SBOM generation (anchore/sbom-action or composer audit --format=json artifact) plus cosign image signing to the release path in autorelease.yml/Dockerfile pipeline; add one exemplary command DTO with Symfony Validator constraints under src/CompanySubdomain/SomeModule/Application to establish the input-validation pattern; document the CSRF-off decision in config/packages/framework.yaml or README.md.

### interactivity — 3/5

**Evidence:** API Platform Swagger UI is exposed at https://localhost/api/docs (config/routes/api_platform.yaml, README Quick start), Structurizr Lite serves interactive architecture diagrams at :8080, and Makefile offers `make sh`, `make logs`, `make new-logs`, `make commands`. However GraphiQL is explicitly disabled in config/packages/api_platform.yaml (graphiql.enabled: false) even for dev, and composer.json contains no symfony/web-profiler-bundle or debug-bundle, so there is no Symfony profiler/debug toolbar for interactive debugging.

**Gaps:**
- GraphiQL disabled globally, leaving the GraphQL endpoint without an interactive explorer in dev
- No symfony/web-profiler-bundle / debug toolbar for dev-time request inspection
- No ready-made HTTP client collection (Postman/Insomnia/.http files) for trying endpoints outside Swagger UI

**Recommendation:** Enable GraphiQL for the dev environment only (when@dev override in config/packages/api_platform.yaml), add symfony/web-profiler-bundle as a require-dev dependency with when@dev config, and ship a small .http or Postman collection covering the health-check and example resource endpoints.

### interchangeability — 4/5

**Evidence:** Hexagonal ports in Domain with adapters in Infrastructure: UuidFactoryInterface (src/Shared/Domain/Factory) implemented by Shared/Infrastructure/Factory/UuidFactory, CommandBusInterface/EventBusInterface with InMemorySymfonyCommandBus/InMemorySymfonyEventBus adapters, UuidInterface value-object abstraction, DI wiring in YAML so implementations swap without touching consumers; deptrac forbids Domain depending on anything (Domain: [] ruleset), guaranteeing adapters stay replaceable.

**Gaps:**
- Each port has exactly one shipped implementation and no test double/second adapter demonstrating a swap (e.g. no async SQS-backed event bus alongside the in-memory one despite SQS being wired), so interchangeability is asserted by structure but never exercised
- No repository port/adapter pair is present in the sample module (SomeModule/Infrastructure has only Provider wiring), leaving the most common swap point (persistence) undemonstrated

**Recommendation:** Add a second adapter for one port (e.g. AsyncSqsEventBus next to InMemorySymfonyEventBus, selected via services_prod.yaml) and a sample Domain repository interface with a Doctrine adapter in SomeModule/Infrastructure to demonstrate persistence interchange.

### interoperability — 4/5

**Evidence:** Dual API surface via API Platform 4: REST with OpenAPI 3.1 export (.github/openapi-spec/spec.yaml, `make generate-openapi-spec`) and GraphQL with Relay-spec SDL export (.github/graphql-spec/spec, node/cursor connections); Mercure and Vulcain supported through FrankenPHP/Caddy; async integration via Symfony Messenger over SQS (MESSENGER_TRANSPORT_DSN in .env) with LocalStack emulation; Spectral (.spectral.yaml) and Schemathesis enforce contract quality in CI.

**Gaps:**
- The async messaging contract (SQS send-email queue) has no published schema — no AsyncAPI document alongside the OpenAPI/GraphQL exports
- No documented API versioning/deprecation strategy for consumers (spec info.version is static 1.0.0 while composer.json is 1.11.0)

**Recommendation:** Add an AsyncAPI spec under .github/asyncapi-spec/ describing the Messenger/SQS contract with a `make generate-asyncapi-spec`-style check, and sync the OpenAPI info.version with the release version emitted by autorelease.yml.

### intuitiveness — 4/5

**Evidence:** Make target names map directly to intent (unit-tests, integration-tests, setup-test-db, load-tests, ci); RFC 7807 problem+json errors are enabled (config/packages/api_platform.yaml: rfc_7807_compliant_errors: true, error_formats jsonproblem) giving predictable machine-readable API errors; the SKILL-DECISION-GUIDE decision tree routes tasks by intent; src layout names express roles (Domain/Application/Infrastructure, HealthCheck module as working reference).

**Gaps:**
- Placeholder module src/CompanySubdomain/SomeModule has no accompanying guide on how to rename/replace it when bootstrapping a real service from the template
- Template-inherited env vars in .env (EMAIL_QUEUE_NAME=send-email, Mercure secret) are unexplained, leaving new users unsure what is required vs. vestigial

**Recommendation:** Add a 'Bootstrapping a new service' section (README or docs/NEW-SERVICE.md) that walks through renaming CompanySubdomain/SomeModule, updating deptrac.yaml/workspace.dsl, and documents each .env variable's purpose with inline comments.

### learnability — 4/5

**Evidence:** README.md explains why the template exists, quick start, entry-point URLs, CI model, and reading order; AGENTS.md + CLAUDE.md + 10 concise .claude/skills (33-63 lines each) encode workflows step by step; CONTRIBUTING.md covers the full contribution flow including Conventional Commits and autorelease; CHANGELOG.md exists; working reference implementations (src/Internal/HealthCheck, features/health_check.feature, tests/) show the intended patterns end to end.

**Gaps:**
- Troubleshooting and wiki docs are external to the repo (github.com/.../wiki), so cloned/synced downstream repos lose them
- No ADRs or in-repo architecture narrative beyond the raw workspace.dsl
- No step-by-step 'from template to first deployed service' tutorial

**Recommendation:** Vendor the wiki's troubleshooting content into docs/TROUBLESHOOTING.md, add docs/adr/ with the key decisions already implied (FrankenPHP, hexagonal layers, contract snapshots in .github/), and write a first-service tutorial that a new hire can follow in under an hour.

### localizability — 2/5

**Evidence:** Scaffolding exists but is empty: translations/ directory contains zero files; config/packages/translation.yaml sets default_path and en fallback with commented-out Crowdin/Loco/Lokalise provider examples; framework default_locale: en. No code in src/ uses TranslatorInterface or trans() (grep found no matches), no locale negotiation for API responses, and no i18n workflow documentation anywhere.

**Gaps:**
- translations/ directory is completely empty (no validators.en.yaml or messages catalog)
- No demonstration of translated validation/error messages through the RFC 7807 error pipeline
- No Accept-Language locale negotiation configured for the API
- No documented translation workflow (providers are only commented-out stubs)

**Recommendation:** Ship a working i18n example: add translations/validators.en.yaml plus one non-English locale (e.g. validators.uk.yaml), use a translatable constraint message in the example resource validation so /api errors return localized RFC 7807 detail based on Accept-Language (framework set_locale_from_accept_language: true), cover it with a Behat scenario, and document the translation-provider workflow in README.

### maintainability — 4/5

**Evidence:** Defense-in-depth quality gates all CI-enforced per PR: PHPInsights 100/100/100/95 minimums (phpinsights.php), Deptrac fail-on-uncovered, Psalm+taint, PHPMD, PHP CS Fixer, Rector dry-run, Infection, codecov, plus scripts/validate-configuration.sh preventing gate-weakening and AGENTS.md contract 'Do not lower quality gates'; tiny surface (32 PHP files in src/), conventional-commit hooks (captainhook.json), CHANGELOG.md, CodeClimate maintainability badge.

**Gaps:**
- Psalm at errorLevel 8 and Infection without minMsi mean two of the headline gates are unenforced in substance
- Dependency freshness debt (phpunit ^9.5, proxy-manager-bridge) contradicts the maintenance posture

**Recommendation:** Close the two soft gates (psalm.xml errorLevel toward 1-3, minMsi in infection.json5) and clear the composer.json legacy pins; after that the maintainability story is fully enforced rather than partially aspirational.

### manageability — 3/5

**Evidence:** Container healthchecks with sensible intervals/start_period for php (curl /ping) and postgres (pg_isready) in docker-compose.yml; restart: unless-stopped; docker-compose.prod.yml override; full DB lifecycle via SETUP_DB make macro and doctrine migrations; load-test stack lifecycle automated with trap-based teardown in Makefile RUN_LOAD_TEST.

**Gaps:**
- No orchestrator manifests (Kubernetes/Helm/ECS task defs) despite being an enterprise microservice template — compose only
- No graceful-shutdown/scaling documentation for FrankenPHP worker mode
- No CD workflow deploying the built image anywhere (workflows are verification-only)

**Recommendation:** Add reference deployment manifests (e.g. infrastructure/k8s/ with Deployment + liveness/readiness probes mapped to /ping and /api/health, resource limits, HPA example) or an ECS/Terraform example consistent with the existing AWS load-test tooling, plus a deploy workflow skeleton in .github/workflows/.

### mobility — 4/5

**Evidence:** Workload moves cleanly between environments: everything runs in containers with dev/prod parity on the same FrankenPHP base (frankenphp_dev vs frankenphp_prod targets); configuration is 12-factor env-var driven (docker-compose.yml env interpolation, composer dump-env prod); AWS dependencies are emulated locally via LocalStack (SERVICES=sqs,ec2,s3,iam,sts in docker-compose.override.yml with init-aws.sh); state is isolated in named volumes (db_data, caddy_data).

**Gaps:**
- Cloud coupling to AWS (aws/aws-sdk-php, SQS transport, tests/Load/aws-execute-load-tests.sh) with no documented portability path to other clouds/brokers
- No arm64-verified images, so moving dev workloads to Apple Silicon/Graviton hosts is untested (see portability)

**Recommendation:** Document broker/cloud swap points (e.g., alternative MESSENGER_TRANSPORT_DSN examples already hinted in .env comments — promote them to README) and add an arm64 leg to CI so the stack is proven movable across CPU architectures.

### modifiability — 4/5

**Evidence:** Changes are guarded end-to-end: unit/integration/Behat suites (tests/Unit, tests/Integration, tests/Behat, features/), mutation testing, OpenAPI/GraphQL diff workflows catch contract-affecting modifications, deptrac catches layering violations, rector-ci catches style/upgrade drift, and .claude/skills (documentation-sync, openapi-development, structurizr-architecture-sync) tell agents exactly which artifacts to co-modify; `make ci` gives a single local verification command.

**Gaps:**
- No minimum coverage threshold enforced (phpunit.xml.dist has a coverage block but no failure criterion; codecov.yml gating not verified as blocking), so modifications can drop test coverage silently
- Modifying anything matched by deptrac's enumerated regexes (new Application class suffix, e.g. a Query) silently falls out of layer coverage until --report-uncovered fails, with the fix requiring edits to a file agents are told not to touch

**Recommendation:** Enforce a coverage floor (codecov.yml 'project' status with a target and fail_ci_if_error, or phpunit + coverage-check in tests.yml) and make deptrac collectors structural so routine modifications don't require touching the locked deptrac.yaml.

### modularity — 4/5

**Evidence:** Three-tier module organization in src/ (CompanySubdomain/SomeModule bounded context, Internal/HealthCheck supporting module, Shared kernel), each with Domain/Application/Infrastructure layering; Deptrac enforces layer dependencies (Domain: [] — depends on nothing; Application/Infrastructure allowlists) with --fail-on-uncovered; PSR-4 App\ autoload; workspace.dsl models the container structure.

**Gaps:**
- Deptrac layers are horizontal only — there is no rule preventing one bounded context from reaching into another (e.g. SomeModule\Application importing Internal\HealthCheck\Domain would pass the Application->Domain rule), so context isolation is convention, not enforcement
- Shared kernel boundaries are enforced by the same enumerated regexes, and anything unlisted (e.g. Shared/Infrastructure/Controller) relies on exclude patterns rather than positive assignment

**Recommendation:** Add per-context Deptrac layers (or a second deptrac config) with rules forbidding cross-module dependencies except via Shared, e.g. layers keyed on 'App\\CompanySubdomain\\SomeModule\\.*' vs 'App\\Internal\\.*' vs 'App\\Shared\\.*', enforcing bounded-context isolation in CI.

### observability — 2/5

**Evidence:** Dedicated health-check bounded context (src/Internal/HealthCheck/) verifying DB (SELECT 1), cache, and SQS broker, exposed at /api/health with OpenAPI 204/500 responses and covered by unit, integration, Behat (features/health_check.feature) and K6 (tests/Load/scripts/health.js) tests; Caddy access logging enabled (`log` directive); framework php_errors.log: true. But monolog/monolog-bundle is absent from composer.json and composer.lock, and there is no OpenTelemetry, no metrics, no correlation IDs, no APM/error tracking anywhere in the repo.

**Gaps:**
- No structured application logging: monolog-bundle not installed, no config/packages/monolog.yaml, no JSON-to-stderr formatter for container log collection
- No distributed tracing (OpenTelemetry SDK/auto-instrumentation) or request/correlation ID generation and propagation
- No application metrics (Prometheus/StatsD/FrankenPHP metrics) and no error-tracking integration (Sentry or similar)
- No alerting/dashboards guidance for downstream services

**Recommendation:** Install symfony/monolog-bundle with a prod JSON formatter writing to stderr and dedicated channels; add open-telemetry/opentelemetry-auto-symfony (or at minimum a request-ID middleware adding X-Request-Id to logs and responses); enable Caddy metrics for a /metrics endpoint; document the observability stack in README so downstream services inherit it. Reference: this complements, not duplicates, issue #11 (fuzzing/pentest).

### operability — 3/5

**Evidence:** Production image target frankenphp_prod with docker-compose.prod.yml override; /ping liveness used by Docker healthcheck; /api/health readiness covering db/cache/broker; restart policy; K6 smoke/average/stress/spike load tests validating operational behavior (tests/Load/, load-tests.yml workflow); AWS load-testing tooling (make aws-load-tests) proving cloud operation paths.

**Gaps:**
- No in-repo runbooks or incident-response procedures (troubleshooting delegated to an external wiki link in README)
- No messenger failure transport, retry strategy, or dead-letter handling for the SQS transport — async failures are silently lost operational events
- No alerting hooks or SLO definitions despite K6 thresholds existing in tests/Load/config.json.dist

**Recommendation:** Add docs/runbooks/ (service-down, DB-connection-failure, queue-backlog, cache-failure scenarios keyed to the three health subscribers), configure messenger failure_transport with retry_strategy in config/packages/messenger.yaml, and derive documented SLOs from the existing K6 thresholds.

### orthogonality — 4/5

**Evidence:** Concerns are cleanly separated: Domain classes carry zero framework metadata (ExampleApiResource is a plain readonly DTO; API Platform mapping lives in config/api_platform/resources.yaml), validation/mapping/config in YAML per AGENTS.md contract, CQRS command/event buses decouple write flows from side effects, docker/infrastructure concerns isolated under docker/ and infrastructure/, quality tooling each in its own config file and workflow.

**Gaps:**
- Read and write paths are not orthogonal — no Query bus means read logic lives directly in API Platform providers while writes go through the command bus, two different idioms for symmetric concerns
- config/services.yaml mixes generic wiring with concrete AWS SqsClient construction (region/credentials), coupling the core DI file to one vendor integration instead of an importable services_aws.yaml

**Recommendation:** Introduce the query-bus counterpart for read operations and move vendor-specific service definitions (SqsClient) into a dedicated imported config file so core wiring stays vendor-neutral.

### portability — 3/5

**Evidence:** Base images are multi-arch-capable upstream (dunglas/frankenphp:1-php8.3.17-alpine, postgres:16-alpine, composer/composer:2-bin) and all tooling routes through Docker/make, so the template is OS-agnostic for Linux/macOS hosts; .dockerignore and pinned image tags keep builds reproducible.

**Gaps:**
- No explicit multi-platform build: no docker buildx / platforms: linux/amd64,linux/arm64 anywhere in the Dockerfile, compose files, or .github/workflows/ (grep for arm64/amd64/buildx returns nothing)
- Dockerfile line 78 pins symfony-cli by image digest (ghcr.io/symfony-cli/symfony-cli:latest@sha256:e4cf5473...) — if that digest resolves to a single-arch manifest the dev image cannot build on arm64
- All CI runners are ubuntu-latest amd64 only; arm64 is never exercised

**Recommendation:** Add a buildx-based workflow (docker/setup-qemu-action + docker/build-push-action with platforms: linux/amd64,linux/arm64) that at minimum builds both arches on PRs touching the Dockerfile; replace the symfony-cli digest pin with a version tag pinned to a multi-arch manifest-list digest; document Apple Silicon support in README.md.

### precision — 4/5

**Evidence:** Load measurement is methodologically sound: tests/Load/utils/scenariosBuilder.js uses open-model constant-arrival-rate / ramping-arrival-rate executors (accurate latency under fixed RPS, immune to coordinated omission), per-scenario tags isolate threshold evaluation, and thresholdsBuilder.js validates config (throws on non-numeric or <=0 thresholds). tests/Load/execute-load-test.sh runs k6 with --summary-trend-stats='avg,min,med,max,p(95),p(99)' and exports an HTML dashboard per scenario; config.json.dist inserts 60s delayBetweenScenarios to avoid cross-scenario interference. Application code enforces declare(strict_types=1) in every file under src/ (verified by inverse grep) with Psalm/PHPInsights gates in CI.

**Gaps:**
- Performance numbers come from single runs on shared GitHub-hosted runners with no repetition, warm-up discard, or statistical confidence handling, so measurements are noisy
- No stored baselines or run-over-run comparison, so precision of detection (distinguishing regression from runner noise) is unquantified

**Recommendation:** Add repetition and baseline comparison to the K6 harness: run each CI scenario N times (or extend duration with a warm-up stage excluded via k6 time-window thresholds), persist summary JSON (k6 --summary-export) as a workflow artifact, and compare p(95)/p(99) against a committed baseline in tests/Load/results/ with a tolerance band.

### predictability — 4/5

**Evidence:** Pipelines behave predictably: all GitHub Actions are SHA-pinned (e.g., actions/checkout@34e11487... in every workflow), the Schemathesis image is digest-pinned (Makefile SCHEMATHESIS_IMAGE @sha256:85b0...), docker compose uses '--detach --wait', load tests trap-cleanup their stack ('trap ... down --remove-orphans' in RUN_LOAD_TEST), and schemathesis.yml polls readiness for up to 120s instead of racing the app boot.

**Gaps:**
- Unseeded Faker (tests/Unit/UnitTestCase.php) makes individual test inputs vary run-to-run, the main source of unpredictable (flaky) failures in an otherwise pinned setup
- No PHPUnit random execution order (executionOrder) is configured, so hidden inter-test dependencies would surface unpredictably later rather than being flushed out deliberately

**Recommendation:** Seed Faker deterministically and set executionOrder="random" with a logged seed in phpunit.xml.dist so ordering dependencies are found on purpose, not by surprise.

### process capabilities — 4/5

**Evidence:** captainhook.json enforces conventional commit messages via regex (feat|fix|...(#issue):) and runs an extensive pre-commit gate (lint, php-cs-fixer, psalm + taint, phpinsights, unit/integration/behat, rector-ci) in Docker; ramsey/conventional-commits + prepare-commit-msg hook; release process fully automated (autorelease.yml) and documented in .github/AUTORELEASE.md with semver rules; .github/pull_request_template.md, ISSUE_TEMPLATE/ (bug_report, feature_request), CONTRIBUTING.md describing the full PR workflow, .coderabbit.yaml review policy, dependabot.yml with named reviewer, and all PR workflows target branch 'main' implying required-check branch protection.

**Gaps:**
- No CODEOWNERS file anywhere in the repo (find returned nothing), so review routing is unenforced
- Branch protection / required status checks are not captured as code or documented (no rulesets, no settings.yml, no list of required checks in CONTRIBUTING.md)
- pre-push hook is disabled in captainhook.json and .github/linters/ is an empty directory
- SECURITY.md is minimal (3 lines, 'Known vulnerabilities: TBD') with no SLA or supported-versions table

**Recommendation:** Add .github/CODEOWNERS mapping paths to teams; codify branch protection via GitHub repository rulesets (or document the required status checks in CONTRIBUTING.md); flesh out SECURITY.md (disclosure SLA, supported versions); remove or populate the empty .github/linters directory.

### producibility — 3/5

**Evidence:** Reproducible builds: composer.lock committed with pinned platform php 8.3.12 (composer.json config.platform); multi-stage Dockerfile with a hardened frankenphp_prod target (non-root www-data, healthcheck, php.ini-production, classmap-authoritative autoload, dump-env prod); docker-compose.prod.yml + docker-compose.yml with healthchecked postgres; most GitHub Actions pinned by full commit SHA; schemathesis image pinned by sha256 digest in Makefile; symfony-cli binary pinned by digest in Dockerfile; xdebug built from a GPG-verified tag.

**Gaps:**
- No workflow builds or publishes a deployable artifact: autorelease.yml only tags and writes release notes — there is no container image push to any registry on release
- No SBOM, provenance attestation, or image signing (no syft/cosign/SLSA anywhere)
- Base image `dunglas/frankenphp:1-php8.3.17-alpine` and `postgres:${DB_VERSION}-alpine` are tag-pinned, not digest-pinned
- Several workflows use mutable action tags (template-sync-app.yml @v2/@v4, code-lint-and-prettify.yml @v4/@v6) instead of SHAs

**Recommendation:** Add a release/publish workflow that builds the frankenphp_prod target with buildx, pushes to GHCR tagged with the release version, generates an SBOM (anchore/sbom-action), signs with cosign and emits SLSA provenance (actions/attest-build-provenance); digest-pin the frankenphp and postgres base images; SHA-pin the remaining tag-pinned actions.

### provability — 4/5

**Evidence:** Several properties are mechanically proven on every PR: Deptrac proves layer boundaries with zero tolerance (--report-uncovered --fail-on-uncovered); Psalm proves type/taint safety (make psalm, psalm-security with SARIF option); Schemathesis proves API conformance to the committed OpenAPI spec across examples+coverage phases; scripts/validate-configuration.sh proves locked config invariants; mutation testing exists to prove test-suite strength.

**Gaps:**
- The mutation-score proof is not binding: no minMsi/min-covered-msi anywhere (grep across infection.json5, Makefile, workflows returns nothing), so 'tests kill mutants' is asserted but never proven in CI
- No enforced coverage floor, so 'src/ is tested' is not a provable claim from repo config alone

**Recommendation:** Encode the proofs as thresholds: minMsi + minCoveredMsi in infection.json5 and coverage targets in a root codecov.yml, making both required status checks; #11's fuzzing/pentest work will extend provable API robustness.

### recoverability — 2/5

**Evidence:** Container-level recovery is automated: restart: unless-stopped, healthcheck-gated startup ordering, and the entrypoint re-establishes state on boot (waits for DB, runs doctrine:migrations:migrate --no-interaction, docker-entrypoint.sh:51-53); tests/Load/cleanup.sh recovers load-test AWS resources.

**Gaps:**
- No data recovery path at all: no backup means no restore; no runbook, no RTO/RPO discussion in README.md/SECURITY.md/docs
- No messenger failure transport, so failed async messages cannot be replayed (messenger:failed:retry unusable)
- Doctrine migrations down()/rollback procedure never documented; auto-migrate on boot could race across multiple replicas
- No disaster-recovery or environment-rebuild documentation beyond make start

**Recommendation:** Add an operations runbook (docs/operations/recovery.md) covering DB restore, migration rollback (doctrine:migrations:migrate prev), and failed-message replay; add the messenger failure_transport so messenger:failed:retry works; document RTO/RPO expectations for services bootstrapped from this template.

### redundancy — 1/5

**Evidence:** Nothing found: docker-compose.yml and docker-compose.prod.yml define exactly one php service and one database service with no deploy.replicas, no DB replication, no multi-AZ/multi-region guidance; workspace.dsl models a single container with no deployment environment; grep for failover/replica across configs and docs returned no application-level hits.

**Gaps:**
- No service replication or load-balancer topology in any compose file or infrastructure/
- No database replication/standby guidance
- No deployment view in workspace.dsl showing redundant nodes
- No documentation of single-points-of-failure for template adopters

**Recommendation:** Add a production deployment reference with redundancy: deploy.replicas >= 2 for php in docker-compose.prod.yml (or K8s manifests with HPA under infrastructure/), managed-Postgres multi-AZ guidance, a deploymentEnvironment block in workspace.dsl modeling redundant nodes, and a README section listing SPOFs adopters must address.

### relevance — 4/5

**Evidence:** Tests target exactly what this template ships: tests/Unit mirrors src/ (CompanySubdomain, Internal, Shared) including OpenAPI builder classes; health_check.feature covers the template's one real endpoint including all three dependency-failure branches; tests/CLI/bats (8 suites incl. make_validate_configuration_tests.bats, make_aws_load_tests.bats) tests the Makefile/tooling, which is the template's actual product; k6 scenarios and Schemathesis target the exposed API surface.

**Gaps:**
- demo.feature is scaffolding noise ('prove the Behat extension is installed') rather than a relevant behavioral spec
- The 20 CI workflows themselves (template-sync, autorelease) have no tests, though they are core template functionality

**Recommendation:** Replace demo.feature with a feature for a real template capability, and add actionlint (plus a dry-run job for template-sync) so the workflow surface, a first-class template deliverable, is itself tested.

### reliability — 3/5

**Evidence:** Functional reliability is well guarded pre-deploy: PHPUnit unit+integration, Behat E2E (features/health_check.feature), Infection mutation testing, Schemathesis conformance testing, and k6 smoke tests all CI-enforced on PRs to main; runtime has layered healthchecks, restart policies, DB-wait-then-migrate startup, and RFC 7807 errors.

**Gaps:**
- Runtime reliability machinery is thin: no message retries/DLQ, no structured logging or alerting, no backup, single-instance topology
- No MTBF/SLO-oriented monitoring; nothing measures reliability in production
- Infection has no enforced minimum MSI so the mutation gate is advisory

**Recommendation:** Close the runtime gaps (messenger retries+DLQ in config/packages/messenger.yaml, monolog JSON logging, /metrics endpoint), enforce --min-msi in the Makefile infection target, and document an SLO/error-budget starter section in README.md so template consumers inherit measurable reliability.

### repairability — 3/5

**Evidence:** Versioned Doctrine migrations (migrations/, doctrine_migrations.yaml) with make targets for migrate/generate; full DB rebuild path (SETUP_DB, load-fixtures with doctrine:schema:validate); make purge for cache/log reset; comprehensive regression suites (unit/integration/Behat/Infection) that verify repairs; template-sync workflows propagate fixes downstream.

**Gaps:**
- No documented rollback procedure (migrations down-path untested/undocumented, no image-version rollback guidance)
- No backup/restore tooling or docs for the PostgreSQL volume
- No failed-message replay path (no messenger failure transport, so broken async work cannot be repaired/retried)

**Recommendation:** Document and test migration rollback (doctrine:migrations:migrate prev) and container image rollback in a docs/runbooks/rollback.md; add make targets for pg_dump/pg_restore against the db_data volume; add messenger failure transport plus messenger:failed:retry documentation.

### repeatability — 4/5

**Evidence:** Runs are repeatable by construction: every suite starts from a freshly dropped/created/migrated database (SETUP_DB macro in Makefile), load tests run in an isolated compose stack torn down via trap on EXIT, CI and local runs share the same docker-exec code path (Makefile checks CI==1 while GitHub sets CI=true, so both use identical containerized execution), and 'make ci' repeats the full PR gate locally.

**Gaps:**
- Faker\Factory::create() without a seed in tests/Unit/UnitTestCase.php means the same test run twice uses different data, so a failing run is not exactly repeatable
- No documented flaky-test policy or seed-capture mechanism to replay a specific failing run

**Recommendation:** Seed Faker from a fixed or environment-provided value logged in test output, and document the replay procedure in .claude/skills/testing-workflow/ so any red run can be reproduced bit-for-bit.

### reproducibility — 4/5

**Evidence:** Builds are strongly pinned: composer.lock (15k lines) committed with Composer platform pinned to php 8.3.12 (composer.json config.platform), symfony.lock and tests/Load/pnpm-lock.yaml committed, all GitHub Actions SHA-pinned, Schemathesis image pinned by sha256 digest, base image pinned to dunglas/frankenphp:1-php8.3.17-alpine, spectral pinned to 6.15.1, and behat/gherkin pinned exactly to 4.12.0.

**Gaps:**
- composer.json requires "vimeo/psalm": "*" (fully floating constraint, only the lock file pins it)
- tests/Load/Dockerfile uses unpinned 'FROM alpine' and floating 'golang:1.24-alpine'; Dockerfile's 'apk add --no-cache' packages are unversioned, so image rebuilds are not bit-reproducible
- mlocati/php-extension-installer:2.2 and composer/composer:2-bin are tag-pinned, not digest-pinned

**Recommendation:** Constrain vimeo/psalm to a caret range, digest-pin the remaining FROM lines (especially tests/Load/Dockerfile's bare 'alpine'), and let the existing Renovate/dependabot-style flow bump digests.

### resilience — 2/5

**Evidence:** Self-healing basics exist (restart: unless-stopped, healthcheck-driven dependency gating, DB reconnect wait loop) and k6 spike/stress scenarios (tests/Load/run-spike-load-tests.sh, run-stress-load-tests.sh) exercise recovery from load surges, but only smoke runs in CI.

**Gaps:**
- No chaos/fault-injection testing anywhere (no toxiproxy, pumba, or chaos workflow; grep for chaos found nothing)
- No circuit breakers, backoff, or retry policies in application/messaging config
- Spike/stress k6 scenarios exist but are not executed in any CI workflow (only make smoke-load-tests in load-tests.yml)
- No test that the service recovers when Postgres/LocalStack are killed and restarted mid-traffic

**Recommendation:** Add a fault-injection CI job (e.g. docker compose kill database during a k6 run, or toxiproxy latency injection) asserting the service recovers via its healthcheck/restart machinery; add messenger retry/backoff config; schedule the existing stress/spike k6 suites in a nightly workflow.

### responsiveness — 4/5

**Evidence:** Latency SLOs are codified and enforced: tests/Load/utils/thresholdsBuilder.js sets http_req_duration p(99) thresholds per scenario tag plus checks rate>0.99; tests/Load/config.json.dist defines budgets per profile (average p99<200ms, stress<1000ms, spike<5000ms, smoke<9000ms). .github/workflows/load-tests.yml runs `make smoke-load-tests` on every PR to main, and k6 exits non-zero on threshold breach, failing the build. Caddyfile serves an instant /ping used by Docker healthchecks; tests/Load/scripts/health.js checks /health returns 204.

**Gaps:**
- The only budget enforced in CI is the smoke profile with p(99)<9000ms — far too lax to catch a real latency regression; the meaningful 200ms average budget is never enforced automatically
- No APM/profiling integration (no Blackfire/Tideways/OpenTelemetry traces) to diagnose slow requests
- Only the /health endpoint has a load script, so any real resource added from the template starts with zero latency coverage

**Recommendation:** Tighten the smoke threshold in tests/Load/config.json.dist to a realistic value (e.g. p(99)<500ms for a health endpoint on CI runners) so the PR gate can actually catch regressions, and add an opt-in OpenTelemetry/profiler bundle wiring in config/packages/ with docs in README.md.

### reusability — 4/5

**Evidence:** Reuse is the template's core mechanism: two automated downstream-sync workflows (.github/workflows/tempate-sync-pat.yml and template-sync-app.yml via AndreasAugustin/actions-template-sync on a weekly cron with PR labels) documented in .github/TEMPLATE_SYNC_PAT.md and TEMPLATE_SYNC_APP.md; README.md names user-service as a live consumer; Shared kernel (Uuid, buses, OpenApi builders) provides reusable primitives; skills baseline is explicitly 'template-safe' for reuse by downstream agents.

**Gaps:**
- The Shared kernel is reused by file-sync duplication rather than as a versioned composer package, so downstream divergence in src/Shared cannot be reconciled semantically (sync PRs will conflict once services modify shared code)
- Workflow filename typo 'tempate-sync-pat.yml' suggests the sync surface itself lacks polish/tests (no bats test covers sync behavior)

**Recommendation:** Extract src/Shared into a versioned composer package (e.g. vilnacrm/shared-kernel) consumed by the template and downstream services, keeping template-sync for CI/docs/tooling files only; rename tempate-sync-pat.yml to template-sync-pat.yml.

### robustness — 4/5

**Evidence:** Strong automated hostile-input and overload coverage: Schemathesis validates the running API against the generated OpenAPI spec on every PR (.github/workflows/schemathesis.yml, pinned image digest Makefile:13); k6 smoke/average/stress/spike scenario builders with strict p(99) and >99% check thresholds (tests/Load/utils/thresholdsBuilder.js, which itself validates its inputs); Infection mutation testing hardens the test suite; declare(strict_types=1) across src/; RFC 7807 error handling; validator auto-mapping enabled (config/packages/validator.yaml).

**Gaps:**
- Psalm runs at errorLevel=8 (psalm.xml:3) — the most permissive level, far from the strict static guarantees expected at this bar (deeper fuzzing/pentest is already tracked in issue #11, not re-recommended)
- The template ships almost no domain input-validation examples (ExampleApiResource has no Assert constraints) to demonstrate the robustness pattern to adopters

**Recommendation:** Ratchet psalm.xml errorLevel down toward 1-3 (fix resulting findings rather than suppressing), and add a validated example resource (constraints + negative-path Behat scenarios beyond the health check) so bootstrapped services start with a robust input-validation pattern.

### safety — 3/5

**Evidence:** Docker HEALTHCHECK against a /ping endpoint is baked into the Dockerfile and Caddyfile (handle /ping respond 200) with a dedicated src/Internal/HealthCheck DDD module; RFC 7807 compliant errors are enabled in config/packages/api_platform.yaml; http_method_override: false and php_errors.log: true in framework.yaml; the prod stage uses php.ini-production and runs as www-data; K6 load tests (tests/Load/, load-tests.yml) catch capacity regressions before production.

**Gaps:**
- No rate limiting: symfony/rate-limiter is not installed and no limiter config exists in config/packages/
- No container resource limits (cpus/memory) or restart policies in docker-compose.prod.yml
- No runtime monitoring/alerting scaffold (no metrics endpoint, no OpenTelemetry, no alert rules) despite the health check existing

**Recommendation:** Add symfony/rate-limiter with a config/packages/rate_limiter.yaml default policy wired to API Platform, set memory/cpu limits and restart: unless-stopped in docker-compose.prod.yml, and add a metrics/observability baseline (OpenTelemetry SDK exporting via OTLP, documented in README.md) so downstream services inherit fail-safe operations.

### scalability — 3/5

**Evidence:** The template validates behavior under load growth: tests/Load/config.json.dist defines stress (150 RPS/150 VUs) and spike (200 RPS) profiles run via make stress-load-tests / spike-load-tests (Makefile lines 163-167) against an isolated compose stack (docker-compose.load_test.override.yml, setup-load-test-db). The app layer is largely stateless (DDD/CQRS under src/, Postgres externalized, SQS Messenger transport in .env via localstack), which is scale-out friendly.

**Gaps:**
- No horizontal scaling guidance or artifacts: docker-compose.prod.yml is single-instance, there are no Kubernetes/Helm/ECS manifests, no replica/HPA guidance in README.md or workspace.dsl (grep for scal/replica/deploy returns nothing)
- Mercure uses a node-local bolt:///data/mercure.db transport and caddy_data volumes (Caddyfile, docker-compose.yml), which breaks multi-instance deployment
- config/packages/messenger.yaml has an empty routing: block — no async message routing or worker/consumer deployment pattern is demonstrated
- No DB indexing conventions documented and the single migration (migrations/Version20240121122200.php) plus src/ contain no index examples; no connection pooling (PgBouncer) guidance

**Recommendation:** Add a scaling deployment reference: either a k8s/ directory (Deployment with HPA, external Mercure hub, Redis session/cache) or a documented ECS/compose --scale pattern; route at least one message class to the SQS transport with a messenger:consume worker service in docker-compose.prod.yml; document DB indexing conventions and add an indexed-column example in the Doctrine XML mapping plus migration; record the scaling model in workspace.dsl deployment views.

### seamlessness — 4/5

**Evidence:** Highly integrated DX: every operation is a make target (Makefile with 60+ documented targets and `make help`), `make start` brings up the full stack with --wait healthchecks, dev entrypoint enables FrankenPHP --watch automatically, code-lint-and-prettify.yml auto-commits php-cs-fixer/Rector fixes on push to main, captainhook.json wires pre-commit/pre-push/commit-msg hooks automatically via captainhook/plugin-composer, and template-sync workflows deliver upstream improvements to downstream repos without manual work.

**Gaps:**
- Test DB setup (make setup-test-db) and bats submodule init remain separate manual steps not folded into make start or make ci
- The auto-commit style bot (push origin HEAD:main from code-lint-and-prettify.yml) conflicts with any branch-protection setup downstream consumers are told to enable, creating friction in synced repos

**Recommendation:** Fold setup-test-db and `git submodule update --init` into the start/ci flow (idempotent), and switch the lint auto-fix workflow to open a PR (e.g., peter-evans/create-pull-request) instead of pushing directly to main so it works under branch protection.

### securability — 3/5

**Evidence:** Hardened container baseline: prod stage runs as USER www-data with chown-scoped dirs, Alpine FrankenPHP base, php.ini-production, dev-only Xdebug isolated in a separate stage (Dockerfile); attack surface is trimmed (formats restricted to application/json and graphiql disabled in config/packages/api_platform.yaml); session cookies use secure/samesite settings; http_method_override disabled; prod compose forces secrets from the environment.

**Gaps:**
- No HTTP security headers in infrastructure/docker/caddy/Caddyfile: no HSTS, Content-Security-Policy, X-Frame-Options, X-Content-Type-Options, or Referrer-Policy
- No security.yaml scaffold, so downstream teams have no sanctioned place to attach firewalls/authenticators; Mercure allows anonymous subscribers by default
- Container hardening stops at non-root: no read_only rootfs, cap_drop, or no-new-privileges in docker-compose.prod.yml

**Recommendation:** Add a header block to infrastructure/docker/caddy/Caddyfile (Strict-Transport-Security, X-Content-Type-Options nosniff, X-Frame-Options DENY, Referrer-Policy, minimal CSP) and assert them in a Behat feature under features/; ship a commented security.yaml scaffold; add security_opt: no-new-privileges, cap_drop: ALL, and read_only: true with tmpfs for var/ to docker-compose.prod.yml.

### self-sustainability — 4/5

**Evidence:** The template maintains itself and its downstream fleet: dependabot.yml (weekly grouped composer, monthly npm) with conventional-commit prefixes feeding autorelease; template-sync-app.yml/tempate-sync-pat.yml crons push template improvements to consumer repos as PRs (documented in .github/TEMPLATE_SYNC_APP.md and TEMPLATE_SYNC_PAT.md, README 'Repository synchronization' section); autorelease.yml keeps version (composer.json) and CHANGELOG.md current with zero manual steps ([skip ci] release commits visible in git log: v1.7.0→v1.11.0); code-lint-and-prettify.yml self-heals style/Rector drift by committing fixes to main; graphql-diff.yml auto-commits regenerated specs.

**Gaps:**
- No scheduled workflow exercises the build or `make check-security` on main, so dependency CVEs and bit-rot surface only when someone happens to open a PR
- Dependabot lacks github-actions and docker ecosystems, so pinned actions and base images silently age
- Automated PRs (dependabot, template-sync) cannot land without the single hardcoded human reviewer; no auto-merge
- No stale issue/PR management automation

**Recommendation:** Add a cron workflow running `make ci` and `make check-security` weekly on main with failure notifications; extend dependabot.yml with github-actions and docker ecosystems; enable auto-merge for green grouped dependency PRs; add actions/stale for issue hygiene.

### serviceability — 4/5

**Evidence:** Template-sync workflows (.github/workflows/tempate-sync-pat.yml, template-sync-app.yml with TEMPLATE_SYNC_PAT.md/TEMPLATE_SYNC_APP.md docs) push maintenance to downstream repos; Dependabot (.github/dependabot.yml) with grouped updates visible in CHANGELOG history; automated releases (autorelease.yml + conventional-changelog-action); captainhook + ramsey/conventional-commits enforce commit hygiene; CONTRIBUTING.md, SECURITY.md, issue/PR templates present.

**Gaps:**
- Support/troubleshooting knowledge lives only in an external GitHub wiki, so it is not versioned or synced downstream with the template
- No documented supported-versions/upgrade policy for downstream services consuming template syncs (how to resolve sync conflicts)

**Recommendation:** Move or mirror the Troubleshooting wiki content into versioned docs/ so template-sync distributes it, and add an UPGRADING.md describing how downstream repos should review and resolve template-sync PR conflicts.

### simplicity — 4/5

**Evidence:** Application code is minimal and legible: 32 PHP files in src/, single-responsibility classes (ExampleApiResourceProvider is ~35 lines), enforced ceilings via PHPInsights min-complexity 95 and PHPMD codesize/design/cleancode rulesets, PSR-12 + declare(strict_types=1) everywhere (.php-cs-fixer.dist.php), and a discoverable `make help` command surface.

**Gaps:**
- The surrounding machinery is heavy relative to the code: ~19 GitHub workflows, 13 skill documents, 5 quality tools with overlapping style/complexity checks (PHPInsights + PHPMD + CS Fixer + Rector + Psalm), which a newcomer must internalize before a one-line change merges
- rector.php dev mode hard-fails without a warmed dev container XML (throws ContainerNotFoundException), an avoidable sharp edge for the common case

**Recommendation:** Consolidate overlapping lint workflows into a single quality workflow with matrix jobs to shrink the CI surface, and make rector.php degrade gracefully (skip Symfony container XML with a warning instead of throwing) when the cache is cold.

### stability — 4/5

**Evidence:** Change stability is rigorously pinned and automated: composer.lock with pinned platform php 8.3.12 (composer.json config.platform), exact Symfony minor pins (7.3.*), all GitHub Actions pinned to commit SHAs, docker images pinned (schemathesis by sha256 digest, structurizr/lite:2024.07.02, localstack:3.4.0), Dependabot (.github/dependabot.yml), conventional commits enforced via captainhook.json, automated changelog+release on main (.github/workflows/autorelease.yml, CHANGELOG.md), and API-contract drift blocked by openapi-diff.yml/graphql-diff.yml gates.

**Gaps:**
- No soak/endurance load test profile (only smoke/average/stress/spike) to detect memory leaks or drift over sustained runtime — relevant for the long-running FrankenPHP worker model
- postgres image tag comes from unpinned ${DB_VERSION} env with no digest pin, and no canary/staged-rollout guidance for released template versions

**Recommendation:** Add a k6 soak scenario (multi-hour constant load with memory/RSS assertions) to tests/Load/ with a scheduled nightly workflow, and pin the postgres image (digest or exact tag) in docker-compose.yml.

### standards compliance — 4/5

**Evidence:** PSR-4 autoloading (App\ => src/ in composer.json), PSR-12 ruleset in phpcs.xml.dist plus php-cs-fixer (.php-cs-fixer.dist.php) enforced in CI (code-lint-and-prettify.yml); Conventional Commits enforced via captainhook + ramsey/conventional-commits and consumed by autorelease.yml (semver + CHANGELOG.md); OpenAPI 3.1 output linted by a substantial custom Spectral ruleset (.spectral.yaml, 8.9KB); GraphQL follows the Relay connection spec; GitHub Actions pinned to full SHAs.

**Gaps:**
- License contradiction: composer.json declares "license": "proprietary" while LICENSE and README.md say CC0-1.0 (and the OpenAPI spec advertises CC0-1.0) — a compliance-audit red flag
- phpcs.xml.dist (PSR-12) is dead config: no Makefile target or workflow runs phpcs, so PSR-12 is only indirectly enforced through php-cs-fixer
- composer.json package name typo "vilnacrm/php-serice-template" violates naming hygiene for a template meant to be forked

**Recommendation:** Set composer.json license to CC0-1.0 and fix the package name typo; either wire phpcs (PSR-12) into make ci / a workflow or delete phpcs.xml.dist to remove the unenforced config.

### survivability — 2/5

**Evidence:** Only load-surge survival is exercised: k6 spike and stress scenarios simulate sudden overload (tests/Load/run-spike-load-tests.sh, run-stress-load-tests.sh); restart policies and healthchecks give basic crash survival; SECURITY.md exists for vulnerability reporting.

**Gaps:**
- No survival plan for infrastructure loss: no DR/backup, single instance of every component, no multi-AZ/region story
- No degraded-operations mode when a dependency (SQS, cache) is permanently down
- Spike/stress scenarios never run in CI, so overload survivability is unverified over time
- No incident-response or business-continuity runbook (SECURITY.md covers only disclosure)

**Recommendation:** Combine the DR/backup runbook, redundancy reference deployment, and dependency-outage degraded mode recommended above, then schedule the spike/stress k6 suites nightly and add an incident-response section to docs so services from this template can survive infrastructure loss, not just traffic spikes.

### sustainability — 4/5

**Evidence:** Strong anti-decay machinery: phpinsights.php locks min-quality 100 / min-complexity 95 / min-architecture 100 / min-style 100; deptrac run with --report-uncovered --fail-on-uncovered (Makefile); Infection mutation testing in CI; scripts/validate-configuration.sh explicitly treats phpinsights.php, psalm.xml, deptrac.yaml, infection.json5 and .php-cs-fixer.dist.php as LOCKED_CONFIG_FILES; architecture kept reviewable as code in workspace.dsl (Structurizr); CHANGELOG.md auto-maintained; CONTRIBUTING.md, wiki + troubleshooting links, and CLAUDE.md/AGENTS.md contract 'Do not lower quality gates'.

**Gaps:**
- infection.json5 / `make infection` set no --min-msi/--min-covered-msi, so the mutation-testing CI job passes regardless of mutation score — the gate exists but has no threshold
- scripts/validate-configuration.sh (the lock on quality configs) is only invoked from local `make ci`; no GitHub workflow runs it, so CI does not actually block gate-weakening PRs
- License metadata is contradictory: composer.json says "license": "proprietary" while README.md and LICENSE say CC0-1.0
- No Codecov targets config (coverage can silently regress; fail_ci_if_error only guards the upload) and bus factor is high (single maintainer/reviewer 'Kravalg' hardcoded in Makefile and dependabot.yml)

**Recommendation:** Add `--min-msi`/`--min-covered-msi` to the infection target in Makefile (or minMsi in infection.json5); add a CI workflow step running scripts/validate-configuration.sh on PRs; fix composer.json license to match LICENSE (CC0-1.0); add a codecov.yml with project/patch coverage targets.

### tailorability — 3/5

**Evidence:** Tailoring hooks exist: docker-compose override layering, .env externalization, per-env services_{prod,test}.yaml, Makefile variable overrides (SCHEMATHESIS_URL, base_ref, CI=1), phpinsights.php remove/config arrays showing how rules were tailored, and skills that downstream agents inherit.

**Gaps:**
- The template actively resists tailoring of its core policy files: scripts/validate-configuration.sh flags modifications to phpinsights.php, psalm.xml, deptrac.yaml, infection.json5 and .php-cs-fixer.dist.php, and AGENTS.md/skills forbid editing them, with no documented override/opt-out path for downstream services with different constraints
- No per-service extension points (e.g. Makefile include of an optional Makefile.local, or a services-specific skills folder) — downstream repos must fork-edit synced files, which the weekly template-sync will then fight

**Recommendation:** Define sanctioned tailoring seams: support an optional Makefile.local include, document in TEMPLATE_SYNC_*.md which files downstream services may diverge on (with .templatesyncignore examples for actions-template-sync), and give validate-configuration.sh an explicit, documented allowlist mechanism for approved downstream deviations.

### testability — 4/5

**Evidence:** The codebase is built to be tested: hexagonal layering enforced by deptrac.yaml keeps Domain framework-free (per CLAUDE.md contract), abstract UnitTestCase/IntegrationTestCase base classes, DataFixtures, dg/bypass-finals for mocking finals, dedicated test env (.env.test) and one-command harnesses for every layer (make unit-tests / integration-tests / behat / infection / load-tests / setup-test-db), plus agent-facing testing-workflow and quality-standards skills documenting how to run and debug suites.

**Gaps:**
- PHPUnit is pinned to the EOL 9.5 line (composer.json "phpunit/phpunit": "^9.5", SYMFONY_PHPUNIT_VERSION 9.5 in phpunit.xml.dist with deprecated convertDeprecationsToExceptions attribute), limiting modern test tooling (native data-provider attributes, better failure output)
- phpunit.xml.dist ships no strictness knobs (failOnRisky, beStrictAboutOutputDuringTests, executionOrder), so template consumers inherit a permissive harness

**Recommendation:** Upgrade to PHPUnit 10/11 (migrate phpunit.xml.dist schema) and enable strict-mode attributes so downstream services bootstrapped from the template start with a maximally testable, strict harness.

### timeliness — 3/5

**Evidence:** Performance feedback is automated on every PR: .github/workflows/load-tests.yml (pull_request → main) runs `make smoke-load-tests`, where k6 thresholds act as a hard performance budget that fails the merge. Heavier profiles (average/stress/spike) exist as one-command Makefile targets, and tests/Load/aws-execute-load-tests.sh provisions EC2/S3/IAM for full cloud runs (make aws-load-tests).

**Gaps:**
- Only the lax smoke budget (p99<9000ms) gates PRs; average/stress/spike and AWS runs are entirely manual with no scheduled (cron) workflow
- No trend tracking: the HTML dashboards written to tests/Load/results/ are not uploaded as CI artifacts and no history/regression comparison exists across commits
- No alerting or budget dashboard tying load-test outcomes to releases

**Recommendation:** Add a scheduled workflow (e.g. .github/workflows/load-tests-full.yml with `on: schedule`) running average+stress profiles nightly, upload tests/Load/results/*.html and k6 summary JSON via actions/upload-artifact, and fail on regression versus a stored baseline so performance drift is caught between releases, not just at PR time.

### traceability — 3/5

**Evidence:** End-to-end change traceability: conventional commits enforced via captainhook.json, auto-generated CHANGELOG.md linking every change to issues/PRs/commits, GitHub releases via autorelease.yml, API contract drift traced by openapi-diff.yml/graphql-diff.yml against versioned specs in .github/, pinned composer platform and locked deps, coverage tracked in Codecov.

**Gaps:**
- No runtime request traceability: no correlation/request IDs generated or propagated, no OpenTelemetry trace context, so a request cannot be followed across HTTP, Messenger/SQS, and DB layers
- No audit trail for data mutations (no Doctrine loggable/audit extension or domain-event persistence pattern in the template)

**Recommendation:** Add an HTTP middleware/event subscriber that assigns X-Request-Id (symfony/uid) and stamps it onto Messenger envelopes (custom middleware in config/packages/messenger.yaml), plus an example audit-trail pattern (persisted domain events or gedmo loggable) in the ExampleApiResource module; wire IDs into the future monolog config.

### transparency — 4/5

**Evidence:** Design decisions and rationale are exceptionally documented: README explains why the template exists and its enterprise baseline; AGENTS.md + CLAUDE.md + 10 skill guides under .claude/skills/ describe the real verification flow; workspace.dsl (Structurizr) makes architecture reviewable and is served locally via the structurizr container; public quality badges (CodeScene, Codecov, PHPInsights); SECURITY.md, CONTRIBUTING.md, LICENSE, .github/AUTORELEASE.md all present; quality gates explicitly protected ('do not lower quality gates').

**Gaps:**
- Runtime/operational transparency is weak: without structured logs, metrics, or detailed health payloads, the running service's internal state is opaque to operators (the transparency is design-time only)

**Recommendation:** Close the runtime side: once monolog/metrics land (see observability), document in README what the service emits (log schema, metrics list, health semantics of /ping vs /api/health) so operators of downstream services know exactly what to expect.

### ubiquity — 3/5

**Evidence:** Docker-only toolchain (all commands run through docker compose exec per CLAUDE.md/Makefile) makes the template runnable on any Linux/macOS host with Docker; GitHub-native everything (Actions, Dependabot, issue templates, template-sync) means zero external SaaS setup beyond Codecov/CodeScene badges; AI-agent guides (.claude/skills/, AGENTS.md) target multiple assistants (Codex, Claude, Copilot, Cursor per README).

**Gaps:**
- No devcontainer/Codespaces/Gitpod configuration, so the template is not one-click usable in cloud IDEs
- No prebuilt/published container image on any registry — every consumer must build from source
- Heavy bash/GNU-make dependence (scripts/*.sh, Makefile with .RECIPEPREFIX) with no Windows/WSL guidance in README.md

**Recommendation:** Ship .devcontainer/devcontainer.json for Codespaces, publish the frankenphp_prod and frankenphp_dev images to GHCR on release, and add a short Windows/WSL2 note to the README Quick start.

### understandability — 4/5

**Evidence:** Layered documentation: README.md explains why the template exists, the enterprise baseline, quick start, CI model, and sync strategy; AGENTS.md gives a concise working contract; CLAUDE.md plus 13 .claude/skills documents (AI-AGENT-GUIDE, SKILL-DECISION-GUIDE, 10 SKILL.md files) map tasks to workflows; workspace.dsl + Structurizr Lite render architecture at localhost:8080; CONTRIBUTING.md, SECURITY.md, CHANGELOG.md, issue/PR templates present; code self-documents intent (placeholder resource literally instructs replacement).

**Gaps:**
- No Architecture Decision Records — the reasoning behind key choices (FrankenPHP, in-memory buses over messenger routing, deptrac regex style, locked configs) lives nowhere reviewable in-repo
- Deeper docs are offloaded to an external GitHub wiki (README links for troubleshooting), which template-sync does not propagate to downstream repos

**Recommendation:** Add a docs/adr/ directory (MADR format) capturing the existing major decisions, and migrate the load-bearing wiki pages (troubleshooting, architecture rationale) into the repo so downstream syncs carry them.

### upgradability — 4/5

**Evidence:** Strong automated upgrade machinery: .github/dependabot.yml (composer weekly grouped all-deps, npm monthly for tests/Load); rector.yml workflow plus rector.php keep code on current PHP/Symfony idioms; autorelease.yml generates semver releases and CHANGELOG.md from conventional commits (CHANGELOG shows regular dependency-bump releases up to v1.11.0); the standout is downstream upgradability — template-sync-app.yml and tempate-sync-pat.yml push template updates to consumer repos weekly via cron, documented in .github/TEMPLATE_SYNC_APP.md and TEMPLATE_SYNC_PAT.md.

**Gaps:**
- dependabot.yml omits the github-actions and docker ecosystems, so SHA-pinned actions (e.g., actions/checkout@34e11487...) and pinned base images (frankenphp:1-php8.3.17-alpine, structurizr/lite:2024.07.02, localstack:3.4.0) never receive automated updates
- No UPGRADE.md or documented major-version upgrade path (PHP 8.3 -> 8.4/next, Symfony 7 -> 8) for template consumers
- Workflow filename typo tempate-sync-pat.yml propagates to every downstream repo via sync

**Recommendation:** Add package-ecosystem: github-actions and package-ecosystem: docker entries to .github/dependabot.yml, rename tempate-sync-pat.yml to template-sync-pat.yml, and add an UPGRADE.md describing the PHP/Symfony major-bump procedure (composer platform pin, Dockerfile base tag, Rector set updates).

### usability — 4/5

**Evidence:** Overall developer experience is strong: one-command boot (`make start`), self-documenting `make help`, full local CI parity (`make ci` with CI=1 switch matching .github/workflows/*), Swagger UI API docs, RFC 7807-compliant errors, issue/PR templates, CONTRIBUTING.md, dependabot, autorelease docs, and an AI-assistant guidance layer (AGENTS.md, CLAUDE.md, .claude/skills) that doubles as human onboarding material.

**Gaps:**
- SECURITY.md is 6 lines with a 'TBD' known-vulnerabilities section
- Critical operational docs (troubleshooting) live only on the external wiki
- First-run flow requires reading multiple files to learn you also need `make install` and `make setup-test-db` after `make start`
- No interactive GraphQL explorer or dev profiler (see interactivity)

**Recommendation:** Flesh out SECURITY.md (supported versions, response SLA, replacing 'TBD'), consolidate a complete first-run sequence (start -> install -> setup-test-db -> smoke check URL) into one copy-pasteable README block or `make bootstrap` target, and move troubleshooting docs in-repo so downstream template consumers inherit them.

### vulnerability — 3/5

**Evidence:** Multiple automated layers exist: SCA via symfony security:check in CI (.github/workflows/symfony.yml -> make check-security, also a captainhook pre-commit action); SAST via Psalm taint analysis with SARIF upload to GitHub code scanning (psalm.yml -> make psalm-security-sarif, Makefile lines 96-100); Dependabot weekly for composer and monthly for tests/Load npm (.github/dependabot.yml); Schemathesis property-based API testing in CI (schemathesis.yml); pheromone/phpcs-security-audit is in composer.json require-dev; SECURITY.md exists with private-disclosure instructions.

**Gaps:**
- No secrets scanning in CI or pre-commit (no gitleaks/trufflehog workflow) and no documented reliance on GitHub push protection
- No container image scanning (Trivy/Grype) for the FrankenPHP image built from the Dockerfile, and no CodeQL analysis workflow (only SARIF upload of Psalm results)
- pheromone/phpcs-security-audit is installed but not activated: phpcs.xml.dist references only PSR12, and the phpinsights CI target runs with --disable-security-check (Makefile line 107)
- SECURITY.md 'Known vulnerabilities' section is a TBD stub; no DAST/pentest in CI (tracked by open issue #11, so not re-recommended here)

**Recommendation:** Add a gitleaks/gitleaks-action workflow (and a captainhook pre-commit hook) for secrets scanning; add aquasecurity/trivy-action scanning the built Dockerfile image with SARIF upload in a new .github/workflows/container-scan.yml; enable the Security ruleset from pheromone/phpcs-security-audit in phpcs.xml.dist; replace the SECURITY.md stub with supported versions and advisory process. (DAST/fuzzing is already covered by open issue #11.)
