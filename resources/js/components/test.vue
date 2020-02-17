<style scoped>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>

<template>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <a href="/login">登录</a>
            <a href="/register">注册</a>
        </div>
        <div class="content">
            <div class="title m-b-md">
                Laravel
            </div>
            <div class="links">
              asdhasjfhksajhfdksjh
                <el-row>
                    <el-button>默认按钮</el-button>
                    <el-button type="primary" v-on:click="test">主要按钮</el-button>
                    <el-button type="success">成功按钮</el-button>
                    <el-button type="info">信息按钮</el-button>
                    <el-button type="warning">警告按钮</el-button>
                    <el-button type="danger">危险按钮</el-button>
                </el-row>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        methods:{
            test(){
                console.log('数据测试')
                this.axios.get('/api/test').then(function(response){
                  console.log(response.data)
                }).catch(
                    function(error){
                        console.log("图片组数据加载错误",error)
                    }
                )
            }
        }
    }
</script>