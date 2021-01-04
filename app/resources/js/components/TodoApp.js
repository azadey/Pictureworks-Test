import React from 'react';
import ReactDOM from 'react-dom';
import Axios from "axios";

import TodoForm from './TodoForm';
import TodoList from './TodoList';
import Title from './Title';

// Contaner Component
class TodoApp extends React.Component{

    constructor(props){
        // Pass props to parent class
        super(props);
        // Set initial state
        this.state = {
            data: []
        }

        this.apiUrl = 'https://57b1924b46b57d1100a3c3f8.mockapi.io/api/todos';
    }

    // Lifecycle method
    componentDidMount(){
        // Make HTTP reques with Axios
        Axios.get(this.apiUrl)
            .then((res) => {
                // Set state with result
                this.setState({data:res.data});
            });
    }

    // Add todoapp handler
    addTodo(val){
        // Assemble data
        const todo = {text: val}
        // Update data
        axios.post(this.apiUrl, todo)
            .then((res) => {
                this.state.data.push(res.data);
                this.setState({data: this.state.data});
            });
    }

    // Handle remove
    handleRemove(id){

        // Filter all todos except the one to be removed
        const remainder = this.state.data.filter((todo) => {
            if(todo.id !== id) return todo;
        });

        // Update state with filter
        axios.delete(this.apiUrl+'/'+id)
            .then((res) => {
                this.setState({data: remainder});
            })
    }

    render(){
        // Render JSX
        return (
            <div>
                <Title todoCount={this.state.data.length} />
                <TodoForm addTodo={this.addTodo.bind(this)}/>
                <TodoList
                    todos={this.state.data}
                    remove={this.handleRemove.bind(this)}
                />
            </div>
        );
    }
}


if (document.getElementById('container')) {
    ReactDOM.render(<TodoApp />, document.getElementById('container'));
}

