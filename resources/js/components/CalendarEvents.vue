<template>
    <div>
        <el-card class="box-card">
            <div slot="header">
                <b>Calendar</b>
            </div>
            <b-row>
                <b-col lg="4">
                    <b-row>
                        <b-col lg="12">
                            <p>Event</p>
                            <el-input
                                v-model="event.name">
                            </el-input>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="6">
                            <p>From</p>
                            <el-date-picker
                                class="w-100"
                                placeholder="Pick a day"
                                type="date"
                                v-model="event.from"
                                value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </b-col>
                        <b-col lg="6">
                            <p>To</p>
                            <el-date-picker
                                class="w-100"
                                placeholder="Pick a day"
                                type="date" v-model="event.to"
                                value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </b-col>
                    </b-row>
                    <el-row :gutter="12" style="margin-top: 10px">
                        <el-col :span="24">
                            <el-checkbox-group v-model="event.day">
                                <el-checkbox label="Mon"></el-checkbox>
                                <el-checkbox label="Tue"></el-checkbox>
                                <el-checkbox label="Wed"></el-checkbox>
                                <el-checkbox label="Thu"></el-checkbox>
                                <el-checkbox label="Fri"></el-checkbox>
                                <el-checkbox label="Sat"></el-checkbox>
                                <el-checkbox label="Sun"></el-checkbox>
                            </el-checkbox-group>
                        </el-col>
                    </el-row>
                    <el-button @click="saveEvents" type="primary">Save</el-button>
                </b-col>
                <b-col :key="key" lg="8">
                    <h1>{{ current.date }}</h1>
                    <div style="margin-top: 5px; overflow-y: auto; height: 600px">
                        <table :key="item.day" class="t1" v-for="item in data" width="100%">
                            <tr :class="(item.eventName.length > 0) ? 'highlight': 'no-color'">
                                <td style="width: 20%">
                                    {{item.date}}
                                </td>
                                <td>
                                    {{item.eventName}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </b-col>
            </b-row>
        </el-card>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "CalendarEvents",
        data() {
            return {
                event: {
                    name: '',
                    from: '',
                    to: '',
                    day: [],
                },
                data: [],
                current: {
                    date: '',
                },
                key: 1,
            };
        },
        created() {
            this.getCurrentMonth();
            this.getEvents();

        },
        methods: {
            getCurrentMonth() {
                const self = this;
                axios({
                    method: 'get',
                    url: 'calendar/current_month',
                    params: {
                        to: this.event.to,
                        from: this.event.from,
                    },
                })
                    .then(function (response) {
                        //handle success
                        self.current.date = response.data;
                    })
                    .catch(function (response) {
                        //handle error
                        console.log(response);
                    });
            },

            getEvents: function () {
                const self = this;
                axios({
                    method: 'get',
                    url: 'calendar/events_list',
                    params: {
                        to: this.event.to,
                        from: this.event.from,
                    },
                })
                    .then(function (response) {
                        //handle success
                        self.data = response.data;
                    })
                    .catch(function (response) {
                        //handle error
                        console.log(response);
                    });

                this.key = this.key + 1;
            },

            saveEvents: function () {
                const data = new FormData();
                data.append('event', this.event.name);
                data.append('to', this.event.to);
                data.append('from', this.event.from);
                data.append('day', this.event.day);

                const self = this;

                axios({
                    method: 'post',
                    url: 'calendar/events',
                    data: data,
                    headers: {'Content-Type': 'multipart/form-data'}
                })
                    .then(function (response) {
                        //handle success
                        if (response.data === 1) {
                            self.$message({
                                message: 'Event successfully saved',
                                type: 'success'
                            });
                        }

                    })
                    .catch(function (response) {
                        //handle error
                        console.log(response);
                    });

                this.getCurrentMonth();
                this.getEvents();
            },
        },
    }
</script>

<style scoped>
    .highlight {
        background-color: #ccffcc;
    }

    .no-color {
        background-color: white;

    }

    .t1 tr:first-child td {
        border-top: 1px solid rgba(128, 128, 128, 0.99);
        padding: 10px;
    }

    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
</style>
