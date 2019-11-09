function showGrid(gridId){
    switch (gridId){
        case 0:
            showConsultantsGrid();
            break;
        case 1:
            showCustomersGrid();
            break;
        case 2:
            showProductsGrid();
            break;
        case 3:
            showProductTypesGrid();
            break;
        case 4:
            showPhotoCentersGrid();
            break;
        case 5:
            showServicesGrid();
            break;
        case 6:
            showUsersGrid();
            break;
        case 7:
            showUserTypesGrid();
            break;
        default:
            break;
    }
}


function badResponseHandler (errdata){
    var parse = errdata.responseJSON;
    note({
      content: parse['log_text'],
      type: parse['log_type'],
      time: parse['log_time']
    });
}


function showCustomersGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/customers_h.php";
    $("#jsGrid").jsGrid({
        height: "70vh",
        width: "100%",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: $url,
                    data: filter,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            }
        },
        fields: [
            { name: "full_name", title: "ФИО", type: "text", width: 150 },
            { name: "age", title: "Возраст", type: "number", width: 50},
            { type: "control" }
        ]
    });
};

function showConsultantsGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/consultants_h.php";

    $.when(
        $.ajax({
            type: "GET",
            url: "request_handlers/photo_centers_h.php"
        })
    ).then(
        function(photo_centers){
            photo_centers.unshift({pc_id: 0, chains_name: "", address: ""});

            $("#jsGrid").jsGrid({
                    height: "70vh",
                    width: "100%",
                    filtering: true,
                    inserting: true,
                    editing: true,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    pageSize: 10,
                    pageButtonCount: 5,
                    controller: {
                        loadData: function(filter) {
                            return $.ajax({
                                type: "GET",
                                url: $url,
                                data: filter,
                                success: function(res){
                                    return res;
                                },
                                statusCode: {
                                    406: function(errdata){
                                        badResponseHandler(errdata);
                                    }
                                }
                            });
                        },
                        insertItem: function(item) {
                            return $.ajax({
                                type: "POST",
                                url: $url,
                                data: item,
                                success: function(res){
                                    return res;
                                },
                                statusCode: {
                                    406: function(errdata){
                                        badResponseHandler(errdata);
                                    }
                                }
                            });
                        },
                        updateItem: function(item) {
                            return $.ajax({
                                type: "PUT",
                                url: $url,
                                data: item,
                                success: function(res){
                                    return res;
                                },
                                statusCode: {
                                    406: function(errdata){
                                        badResponseHandler(errdata);
                                    }
                                }
                            });
                        },
                        deleteItem: function(item) {
                            return $.ajax({
                                type: "DELETE",
                                url: $url,
                                data: item,
                                success: function(res){
                                    return res;
                                },
                                statusCode: {
                                    406: function(errdata){
                                        badResponseHandler(errdata);
                                    }
                                }
                            });
                        }
                    },
                    fields: [
                        { name: "full_name", title: "ФИО", type: "text", width: 50 },
                        { name: "passport_data", title: "Паспортные данные", type: "text", width: 25 },
                        { name: "phone", title: "Моб.Телефон", type: "text", width: 30 },
                        { name: "sex", title: "Пол", type: "text", width: 5 },
                        { name: "birth_date", title: "Дата Рождения", type: "date", width: 20 },
                        { name: "pc_id", title: "Название салона",
                            type: "select",
                            items: photo_centers,
                            valueFuild: "pc_id",
                            textField: "chains_name",
                            editing: false,
                            filtering: false,
                            width: 50
                        },
                        { name: "pc_id", title: "Место работы",
                            type: "select",
                            items: photo_centers,
                            valueFuild: "pc_id",
                            textField: "address",
                            width: 70
                        },
                        { type: "control" }
                    ]
                });
        }
    );

};

function showPhotoCentersGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/photo_centers_h.php";

    $("#jsGrid").jsGrid({
        height: "70vh",
        width: "100%",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        deleteConfirm: function(item) {
            return "Фотоцентр \"" + item.chains_name + "\" в \"" + item.address + "\" будет удален. Вы уверены?";
        },
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: $url,
                    data: filter,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }

                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            }
        },
        fields: [
            { name: "chains_name", title: "Название", type: "text", width: 50 },
            { name: "address", title: "Адрес", type: "text", width: 30 },
            { name: "office_hours", title: "Часы работы", type: "text", width: 30 },
            { name: "phone", title: "Телефон", type: "text", width: 30 },
            { type: "control" }
        ]
    });
};

function showProductsGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/products_h.php";

    $.when(
        $.ajax({
            type: "GET",
            url: "request_handlers/product_types_h.php"
        })
    ).then(
        function(product_types){
            product_types.unshift({product_types_id: 0, product_types_name: ""});

            $("#jsGrid").jsGrid({
                height: "70vh",
                width: "100%",
                filtering: true,
                inserting: true,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 10,
                pageButtonCount: 5,
                controller: {
                    loadData: function(filter) {
                        return $.ajax({
                            type: "GET",
                            url: $url,
                            data: filter,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    },
                    insertItem: function(item) {
                        return $.ajax({
                            type: "POST",
                            url: $url,
                            data: item,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    },
                    updateItem: function(item) {
                        return $.ajax({
                            type: "PUT",
                            url: $url,
                            data: item,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    },
                    deleteItem: function(item) {
                        return $.ajax({
                            type: "DELETE",
                            url: $url,
                            data: item,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    }
                },
                fields: [
                    { name: "product_name", title: "Название", type: "text", width: 50 },
                    { name: "product_price", title: "Цена", type: "number", width: 30 },
                    { name: "product_types_id", title: "Тип",
                        type: "select",
                        items: product_types,
                        valueFuild: "product_types_id",
                        textField: "product_types_name"
                    },
                    { type: "control" }
                ]
            });
        }
    );
};

function showProductTypesGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/product_types_h.php";
    $("#jsGrid").jsGrid({
        height: "70vh",
        width: "100%",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: $url,
                    data: filter,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            }
        },
        fields: [
            { name: "product_types_name", title: "Название", type: "text", width: 50 },
            { type: "control" }
        ]
    });
};

function showServicesGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/service_h.php";

    $.when(
        $.ajax({
            type: "GET",
            url: "request_handlers/consultants_h.php"
        }),
        $.ajax({
            type: "GET",
            url: "request_handlers/products_h.php"
        }),
        $.ajax({
            type: "GET",
            url: "request_handlers/customers_h.php"
        })
    ).then(
        function(consultants, products, customers){
            consultants[0].unshift({consultant_id: 0, full_name: ""});
            products[0].unshift({product_id: 0, product_name: ""});
            customers[0].unshift({customer_id: 0, full_name: ""});

            $("#jsGrid").jsGrid({
                height: "70vh",
                width: "100%",
                filtering: true,
                inserting: true,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 10,
                pageButtonCount: 5,
                controller: {
                    loadData: function(filter) {
                        return $.ajax({
                            type: "GET",
                            url: $url,
                            data: filter,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    },
                    insertItem: function(item) {
                        return $.ajax({
                            type: "POST",
                            url: $url,
                            data: item,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    },
                    updateItem: function(item) {
                        return $.ajax({
                            type: "PUT",
                            url: $url,
                            data: item,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    },
                    deleteItem: function(item) {
                        return $.ajax({
                            type: "DELETE",
                            url: $url,
                            data: item,
                            success: function(res){
                                return res;
                            },
                            statusCode: {
                                406: function(errdata){
                                    badResponseHandler(errdata);
                                }
                            }
                        });
                    }
                },
                fields: [
                    { name: "consultant_id", title: "Консультант",
                        type: "select",
                        items: consultants[0],
                        valueFuild: "consultant_id",
                        textField: "full_name",
                        width: 70
                    },
                    { name: "product_id", title: "Услуга",
                        type: "select",
                        items: products[0],
                        valueFuild: "product_id",
                        textField: "product_name",
                        width: 50
                    },
                    { name: "customer_id", title: "Покупатель",
                        type: "select",
                        items: customers[0],
                        valueFuild: "customer_id",
                        textField: "full_name",
                        width: 70
                    },
                    { name: "service_date", title: "Дата", type: "text", width: 30 },
                    { name: "service_time", title: "Время", type: "text", width: 30 },
                    { type: "control" }
                ]
            });
        }
    );
};


function showUsersGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/users_h.php";

    $("#jsGrid").jsGrid({
        height: "70vh",
        width: "100%",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: $url,
                    data: filter,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }

                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            }
        },
        fields: [
            { name: "user_login", title: "Логин", type: "text", width: 30 },
            { name: "user_password", title: "Пароль", type: "text", width: 125, filtering: false },
            { name: "user_sessid", title: "Сессионный идентификатор", type: "text", width: 55, filtering: false, inserting: false },
            { name: "user_type", title: "Тип пользователя", type: "text", width: 25 },
            { type: "control" }
        ]
    });
};


function showUserTypesGrid(){
    jsGrid.locale("ru");
    $url = "request_handlers/user_types_h.php";

    $("#jsGrid").jsGrid({
        height: "70vh",
        width: "100%",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: $url,
                    data: filter,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }

                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: $url,
                    data: item,
                    success: function(res){
                        return res;
                    },
                    statusCode: {
                        406: function(errdata){
                            badResponseHandler(errdata);
                        }
                    }
                });
            }
        },
        fields: [
            { name: "consultants_t", type: "text", width: 20 },
            { name: "customers_t", type: "text", width: 20 },
            { name: "photo_centers_t", type: "text", width: 20 },
            { name: "products_t", type: "text", width: 20 },
            { name: "product_types_t", type: "text", width: 20 },
            { name: "service_t", type: "text", width: 20 },
            { name: "users_t", type: "text", width: 20 },
            { type: "control" }
        ]
    });
};