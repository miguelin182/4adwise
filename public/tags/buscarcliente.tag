<buscarcliente>


            <input type="text"
                value="{model.apaterno}"
                class="form-control" id="txtFiltro"
                placeholder="Buscar Cliente..."/>






    <script>
            var self=this;

            self.model = new bCliente();

            self.on('mount', function(){
                __clienteAutocomplete();
            })

            function bCliente(){
                this.cliente_id;
                this.nombre;
                this.apaterno;
                this.amaterno;
                this.celular;
            }

                function __clienteAutocomplete(){
                        var client = $("#txtFiltro"),
                                options = {
                                    url: function(q) {
                                        return base_url('prospecto/buscar/'+q);
                                    },
                                    getValue: 'ncompleto',
                                    list: {
                                        onClickEvent: function() {
                                            var e = client.getSelectedItemData();
                                            /* self.model.cliente_id = e.id;
                                            self.model.nombre =e.nombre;
                                            self.model.apaterno =e.apaterno;
                                            self.model.amaterno =e.amaterno;
                                            self.model.celular =e.celular;
                                            self.update();*/
                                            window.location.replace(base_url("prospecto/expediente/"+e.id));
                                        }
                                    },
                                    template: {
                                        type: "custom",
                                        method: function(value, item) {
                                          return "<i class='fa fa-angle-double-right' aria-hidden='true'></i>  "+ value;
                                        }
                                      }
                                };

                        client.easyAutocomplete(options);
                    }

    </script>
</buscarcliente>
