workspace {

    !identifiers hierarchical

    model {
        properties {
            "structurizr.groupSeparator" "/"
        }

        softwareSystem = softwareSystem "VilnaCRM" {
            webApplication = container "PHP Service Template" {

                group "Application" {
                    healthCheckController = component "HealthCheckController" "Handles health check requests" "Controller" {
                        tags "Item"
                    }
                }

                group "Domain" {
                    uuidValueObject = component "Uuid" "Represents a UUID" "ValueObject" {
                        tags "Item"
                    }
                    healthCheckEvent = component "HealthCheckEvent" "Represents a health check event" "DomainEvent" {
                        tags "Item"
                    }
                    uuidFactoryInterface = component "UuidFactoryInterface" "Interface for UUID creation" "Factory" {
                        tags "Item"
                    }
                }

                group "Infrastructure" {
                    dbCheckSubscriber = component "DBCheckSubscriber" "Checks database health" "EventSubscriber" {
                        tags "Item"
                    }
                    cacheCheckSubscriber = component "CacheCheckSubscriber" "Checks cache health" "EventSubscriber" {
                        tags "Item"
                    }
                    brokerCheckSubscriber = component "BrokerCheckSubscriber" "Checks message broker health" "EventSubscriber" {
                        tags "Item"
                    }
                    uuidFactory = component "UuidFactory" "Creates UUIDs" "Factory" {
                        tags "Item"
                    }
                    inMemorySymfonyEventBus = component "InMemorySymfonyEventBus" "Handles event publishing" "EventBus" {
                        tags "Item"
                    }
                    uuidTransformer = component "UuidTransformer" "Transforms UUIDs" "Transformer" {
                        tags "Item"
                    }
                }

                database = component "Database" "Stores application data" "PostgreSQL" {
                    tags "Database"
                }
                cache = component "Cache" "Caches application data" "Redis" {
                    tags "Database"
                }
                messageBroker = component "Message Broker" "Handles asynchronous messaging" "AWS SQS" {
                    tags "Database"
                }

                healthCheckController -> healthCheckEvent "creates"
                healthCheckEvent -> dbCheckSubscriber "triggers"
                healthCheckEvent -> cacheCheckSubscriber "triggers"
                healthCheckEvent -> brokerCheckSubscriber "triggers"
                uuidTransformer -> uuidFactoryInterface "uses"
                uuidFactory -> uuidFactoryInterface "implements"
                uuidFactory -> uuidValueObject "creates"
                dbCheckSubscriber -> database "checks"
                cacheCheckSubscriber -> cache "checks"
                brokerCheckSubscriber -> messageBroker "checks"
                inMemorySymfonyEventBus -> uuidFactory "uses"
            }
        }
    }

    views {
        component softwareSystem.webApplication "Components_All" {
            include *
        }

        styles {
            element "Item" {
                color white
                background #34abeb
            }
            element "Database" {
                color white
                shape cylinder
                background #34abeb
            }
        }
    }
}